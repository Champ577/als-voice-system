/* ================= CONFIG ================= */
const MAX_DURATION = 60000; // 60 sec max

let mediaStream = null;
let audioContext = null;
let analyser = null;
let dataArray = null;
let animationFrame = null;
let activeRecordingKey = null;


/* ================= RECORDINGS STORE ================= */
const recordings = {
  fileA: null,
  fileE: null,
  fileI: null,
  fileO: null,
  fileU: null,
  filePA: null,
  fileTA: null,
  fileKA: null
};

const recorderMap = {};

/* ====== SAMPLE STATE ====== */
let activeSampleAudio = null;
let activeSampleBtn = null;

/* ================= MIC PERMISSION ================= */
async function ensureMicPermission() {
  if (mediaStream) return true;

  try {
    mediaStream = await navigator.mediaDevices.getUserMedia({ audio: true });
    return true;
  } catch (err) {
    showToast(
      'Microphone permission denied. Please allow microphone access.',
      'error'
    );
    return false;
  }
}

/* ================= START RECORD ================= */
async function startRecording(btn) {
  const hasPermission = await ensureMicPermission();
  if (!hasPermission) return;

  const box = btn.closest('.result-card-wrap');
  const key = box.dataset.key;

  if (activeRecordingKey && activeRecordingKey !== key) {
    showToast('Another recording is in progress. Please stop it first.', 'error');
    return;
  }

  if (recorderMap[key]) return;

  const recorder = new MediaRecorder(mediaStream, {
     mimeType: getSupportedMimeType()
  });

  const chunks = [];

  recorder.ondataavailable = e => chunks.push(e.data);

  recorder.onstop = async () => {
    const rawBlob = new Blob(chunks, { type: recorder.mimeType });

  let finalBlob = rawBlob;

  // Convert only if NOT wav
  if (recorder.mimeType !== 'audio/wav') {
    finalBlob = await convertWebMToWav(rawBlob);
  }

  recordings[key] = finalBlob;

    box.querySelector('.voice-status').innerText = 'Recorded';
    stopVoiceVisual();

    btn.disabled = false;
    btn.nextElementSibling.disabled = true;

    delete recorderMap[key];
    activeRecordingKey = null;
    checkAllRecorded();
  };

  try {
    recorder.start();
    activeRecordingKey = key;
    recorderMap[key] = recorder;
  } catch (e) {
    showToast('Unable to start recording', 'error');
    return;
  }


  btn.disabled = true;
  btn.nextElementSibling.disabled = false;
  box.querySelector('.voice-status').innerText = 'Recording...';

  // ===== AUDIO VISUAL =====
  if (audioContext && audioContext.state !== 'closed') {
    audioContext.close();
  }

  audioContext = new (window.AudioContext || window.webkitAudioContext)();
  const source = audioContext.createMediaStreamSource(mediaStream);
  analyser = audioContext.createAnalyser();
  analyser.fftSize = 256;

  source.connect(analyser);
  dataArray = new Uint8Array(analyser.frequencyBinCount);

  startVoiceVisual(box);

  setTimeout(() => {
    if (recorder.state === 'recording') {
      recorder.stop();
    }
  }, MAX_DURATION);
}
async function convertWebMToWav(blob) {
  const arrayBuffer = await blob.arrayBuffer();
  const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  const audioBuffer = await audioCtx.decodeAudioData(arrayBuffer);

  return encodeWAV(audioBuffer);
}
function encodeWAV(audioBuffer) {
  const numChannels = audioBuffer.numberOfChannels;
  const sampleRate = audioBuffer.sampleRate;
  const bitDepth = 16;

  let samples;
  if (numChannels === 2) {
    samples = interleave(
      audioBuffer.getChannelData(0),
      audioBuffer.getChannelData(1)
    );
  } else {
    samples = audioBuffer.getChannelData(0);
  }

  const buffer = new ArrayBuffer(44 + samples.length * 2);
  const view = new DataView(buffer);

  writeString(view, 0, 'RIFF');
  view.setUint32(4, 36 + samples.length * 2, true);
  writeString(view, 8, 'WAVE');
  writeString(view, 12, 'fmt ');
  view.setUint32(16, 16, true);
  view.setUint16(20, 1, true);
  view.setUint16(22, numChannels, true);
  view.setUint32(24, sampleRate, true);
  view.setUint32(28, sampleRate * numChannels * 2, true);
  view.setUint16(32, numChannels * 2, true);
  view.setUint16(34, bitDepth, true);
  writeString(view, 36, 'data');
  view.setUint32(40, samples.length * 2, true);

  floatTo16BitPCM(view, 44, samples);

  return new Blob([view], { type: 'audio/wav' });
}
function interleave(left, right) {
  const length = left.length + right.length;
  const result = new Float32Array(length);
  let index = 0;

  for (let i = 0; i < left.length; i++) {
    result[index++] = left[i];
    result[index++] = right[i];
  }
  return result;
}

function floatTo16BitPCM(view, offset, input) {
  for (let i = 0; i < input.length; i++, offset += 2) {
    let s = Math.max(-1, Math.min(1, input[i]));
    view.setInt16(offset, s < 0 ? s * 0x8000 : s * 0x7fff, true);
  }
}

function writeString(view, offset, string) {
  for (let i = 0; i < string.length; i++) {
    view.setUint8(offset + i, string.charCodeAt(i));
  }
}

function getSupportedMimeType() {
  if (MediaRecorder.isTypeSupported('audio/webm')) {
    return 'audio/webm';
  }
  if (MediaRecorder.isTypeSupported('audio/mp4')) {
    return 'audio/mp4';
  }
  if (MediaRecorder.isTypeSupported('audio/wav')) {
    return 'audio/wav';
  }
  return '';
}



/* ================= STOP RECORD ================= */
function stopRecording(btn) {
  const box = btn.closest('.result-card-wrap');
  const key = box.dataset.key;

  if (!recorderMap[key]) return;
  recorderMap[key].stop();
  activeRecordingKey = null;
}

/* ================= VOICE VISUAL ================= */
function startVoiceVisual(box) {
  const bars = box.querySelectorAll('.voice-visual span');

  function animate() {
    analyser.getByteFrequencyData(dataArray);

    let sum = 0;
    dataArray.forEach(v => sum += v);
    const volume = sum / dataArray.length;

    bars.forEach(bar => {
      const height = Math.max(6, (volume / 255) * 30);
      bar.style.height = height + 'px';
    });

    animationFrame = requestAnimationFrame(animate);
  }

  animate();
}

function stopVoiceVisual() {
  if (animationFrame) {
    cancelAnimationFrame(animationFrame);
    animationFrame = null;
  }

  if (audioContext && audioContext.state !== 'closed') {
    audioContext.close();
  }

  audioContext = null;
  analyser = null;
}

/* ================= CHECK ALL FILES ================= */
function checkAllRecorded() {
  const hasAtLeastOneRecording = Object.values(recordings).some(
    b => b instanceof Blob
  );

  document.getElementById('submitBtn').disabled = !hasAtLeastOneRecording;
}

/* ================= FORM SUBMIT ================= */
document.getElementById('voiceForm').addEventListener('submit', e => {
  e.preventDefault();

  const formData = new FormData(e.target);

  Object.entries(recordings).forEach(([key, blob]) => {
    if (blob) {
      formData.append(key, blob, key + '.wav');
    }
  });

  fetch('upload_voice.php', {
    method: 'POST',
    body: formData,
    credentials: 'same-origin'
  })
    .then(res => res.json())
    .then(res => {
      if (res.status) {
        showToast(res.message, 'success');
        setTimeout(() => {
          window.location.href = res.redirect;
        }, 1500);
      } else {
        showToast(res.message, 'error');
      }
    })
    .catch(() => {
      showToast('Upload failed', 'error');
    });
});

// Close Popup
function closeVoiceModal() {
  stopModalSample();

  const modal = document.getElementById('voiceModal');
  modal.classList.remove('show');

  document.getElementById('voiceModalBody').innerHTML = '';
}

// SampleModal

function openSampleModal(btn) {
  const box = btn.closest('.result-card-wrap');
  const key = box.dataset.key;

  const labelText = box.querySelector('.form-group label')?.innerText || 'Voice Samples';
  document.getElementById('voiceModalTitle').innerText = `Voice Samples for ${labelText}`;

  stopModalSample(); 

  fetch(`get_samples.php?key=${key}`)
    .then(r => r.json())
    .then(files => {
      renderSampleList(files);
      document.getElementById('voiceModal').classList.add('show');
    })
    .catch(() => {
      showToast('Unable to load samples', 'error');
    });
}

function renderSampleList(files) {
  const body = document.getElementById('voiceModalBody');
  body.innerHTML = '';

  if (!files.length) {
    body.innerHTML = '<p>No samples available</p>';
    return;
  }

  files.forEach((src, i) => {
    const row = document.createElement('div');
    row.className = 'sample-row';

    row.innerHTML = `
      <div class="sample-info">
        <strong>Sample ${i + 1}</strong>
        <div class="wave">
          <span></span><span></span><span></span><span></span><span></span>
        </div>
      </div>
      <button class="btn-submit btn-play" onclick="playModalSample(this, '${src}')">
        <i class="fas fa-play"></i>
        <span>Play</span>
      </button>
    `;

    body.appendChild(row);
  });
}


function playModalSample(btn, src) {

  if (activeSampleAudio && activeSampleBtn === btn) {
    stopModalSample();
    return;
  }

  // Stop any existing sample
  stopModalSample();

  const row = btn.closest('.sample-row');
  row.classList.add('playing');

  btn.classList.remove('btn-play');
  btn.classList.add('btn-stopP');
  btn.innerHTML = '<i class="fas fa-stop"></i> <span>Stop</span>';

  const audio = new Audio(src);
  audio.volume = 0.8;

  activeSampleAudio = audio;
  activeSampleBtn = btn;

  audio.play().catch(() => {
    showToast('Audio play failed', 'error');
    stopModalSample();
  });

  audio.onended = stopModalSample;
}


function stopModalSample() {
  if (!activeSampleAudio) return;

  activeSampleAudio.pause();
  activeSampleAudio.currentTime = 0;
  activeSampleAudio = null;

  document.querySelectorAll('.sample-row').forEach(row => {
    row.classList.remove('playing');

    const btn = row.querySelector('button');
    if (!btn) return;

    btn.classList.remove('btn-stopP');
    btn.classList.add('btn-play');
    btn.innerHTML = '<i class="fas fa-play"></i> <span>Play</span>';
  });

  activeSampleBtn = null;
}

