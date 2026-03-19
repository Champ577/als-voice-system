<?php require 'candidate_auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record | All Als, Indian Voice Dataset Initiative for Neurodegenerative Research</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
    <?php include 'loader.php'; ?>
    
    <?php include 'header.php' ?>
    <section class="subHeader">
        <div class="wrapper">
            <div class="breadcumTitle">Record Your Voice</div>
            <div class="inner-breadcrumb">
              <ul>
                <li><a href="./" title="Home"><i class="fa fa-home">&nbsp;&nbsp;</i>Home</a></li> 
                <li>Record</li>
              </ul>
            </div>
        </div>
    </section>
    <section class="recordWrapper">
        <div class="wrapper">
            <div class="voiceWraper">
                <div class="headerWrap">
                    <h2>Record Voice </h2>
                </div>
                <form method="POST" enctype="multipart/form-data" id="voiceForm" onsubmit="return false;">
                    <input type="number" name="age" placeholder="Age" value="<?=$_SESSION['candidate']['age']; ?>" required hidden>
                    <input type="number" name="sex_m" value="<?=$_SESSION['candidate']['gender']; ?>" placeholder="sex_m" required hidden>

                    <div id="voice-grid" class="voice-grid">

                        <!-- ================= Phonation A ================= -->
                        <div class="result-card-wrap" data-key="fileA">
                            <div class="voice-box">
                                <div class="form-group">
                                    <label>Phonation A</label>

                                    <div class="voice-visual">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>

                                    <div class="voice-status">Not recorded</div>
                                
                                </div>
                            </div>

                            <div class="btn-group">
                                <!-- Sample Btn -->
                                <button
                                    type="button"
                                    class="btn-submit btn-sample"
                                    onclick="openSampleModal(this)"
                                >
                                    <span>View Sample</span>
                                </button>
                                <div>
                                    <!-- RECORD BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-record"
                                        onclick="startRecording(this)"
                                        title="Start Recording"
                                    >
                                        <i class="fas fa-microphone"></i>
                                    </button>

                                    <!-- STOP BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-stop"
                                        onclick="stopRecording(this)"
                                        disabled
                                        title="Stop Recording"
                                    >
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Phonation E ================= -->
                        <div class="result-card-wrap" data-key="fileE">
                            <div class="voice-box">
                                <div class="form-group">
                                    <label>Phonation E</label>

                                    <div class="voice-visual">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>

                                    <div class="voice-status">Not recorded</div>
                                    
                                </div>
                            </div>

                            <div class="btn-group">
                                <!-- Sample Btn -->
                                <button
                                    type="button"
                                    class="btn-submit btn-sample"
                                    onclick="openSampleModal(this)"
                                >
                                    <span>View Sample</span>
                                </button>
                                <div>
                                    <!-- RECORD BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-record"
                                        onclick="startRecording(this)"
                                        title="Start Recording"
                                    >
                                        <i class="fas fa-microphone"></i>
                                    </button>

                                    <!-- STOP BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-stop"
                                        onclick="stopRecording(this)"
                                        disabled
                                        title="Stop Recording"
                                    >
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Phonation I ================= -->
                        <div class="result-card-wrap" data-key="fileI">
                            <div class="voice-box">
                                <div class="form-group">
                                    <label>Phonation I</label>

                                    <div class="voice-visual">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>

                                    <div class="voice-status">Not recorded</div>
                                    
                                </div>
                            </div>

                            <div class="btn-group">
                                <!-- Sample Btn -->
                                <button
                                    type="button"
                                    class="btn-submit btn-sample"
                                    onclick="openSampleModal(this)"
                                >
                                    <span>View Sample</span>
                                </button>
                                <div>
                                    <!-- RECORD BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-record"
                                        onclick="startRecording(this)"
                                        title="Start Recording"
                                    >
                                        <i class="fas fa-microphone"></i>
                                    </button>

                                    <!-- STOP BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-stop"
                                        onclick="stopRecording(this)"
                                        disabled
                                        title="Stop Recording"
                                    >
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Phonation O ================= -->
                        <div class="result-card-wrap" data-key="fileO">
                            <div class="voice-box">
                                <div class="form-group">
                                    <label>Phonation O</label>

                                    <div class="voice-visual">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>

                                    <div class="voice-status">Not recorded</div>
                                
                                </div>
                            </div>

                            <div class="btn-group">
                                <!-- Sample Btn -->
                                <button
                                    type="button"
                                    class="btn-submit btn-sample"
                                    onclick="openSampleModal(this)"
                                >
                                    <span>View Sample</span>
                                </button>
                                <div>
                                    <!-- RECORD BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-record"
                                        onclick="startRecording(this)"
                                        title="Start Recording"
                                    >
                                        <i class="fas fa-microphone"></i>
                                    </button>

                                    <!-- STOP BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-stop"
                                        onclick="stopRecording(this)"
                                        disabled
                                        title="Stop Recording"
                                    >
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Phonation U ================= -->
                        <div class="result-card-wrap" data-key="fileU">
                            <div class="voice-box">
                                <div class="form-group">
                                    <label>Phonation U</label>

                                    <div class="voice-visual">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>

                                    <div class="voice-status">Not recorded</div>
                                    
                                </div>
                            </div>

                            <div class="btn-group">
                                <!-- Sample Btn -->
                                <button
                                    type="button"
                                    class="btn-submit btn-sample"
                                    onclick="openSampleModal(this)"
                                >
                                    <span>View Sample</span>
                                </button>
                                <div>
                                    <!-- RECORD BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-record"
                                        onclick="startRecording(this)"
                                        title="Start Recording"
                                    >
                                        <i class="fas fa-microphone"></i>
                                    </button>

                                    <!-- STOP BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-stop"
                                        onclick="stopRecording(this)"
                                        disabled
                                        title="Stop Recording"
                                    >
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Rhythm PA ================= -->
                        <div class="result-card-wrap" data-key="filePA">
                            <div class="voice-box">
                                <div class="form-group">
                                    <label>Rhythm PA</label>

                                    <div class="voice-visual">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>

                                    <div class="voice-status">Not recorded</div>
                                    
                                </div>
                            </div>

                            <div class="btn-group">
                                <!-- Sample Btn -->
                                <button
                                    type="button"
                                    class="btn-submit btn-sample"
                                    onclick="openSampleModal(this)"
                                >
                                    <span>View Sample</span>
                                </button>
                                <div>
                                    <!-- RECORD BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-record"
                                        onclick="startRecording(this)"
                                        title="Start Recording"
                                    >
                                        <i class="fas fa-microphone"></i>
                                    </button>

                                    <!-- STOP BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-stop"
                                        onclick="stopRecording(this)"
                                        disabled
                                        title="Stop Recording"
                                    >
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Rhythm TA ================= -->
                        <div class="result-card-wrap" data-key="fileTA">
                            <div class="voice-box">
                                <div class="form-group">
                                    <label>Rhythm TA</label>

                                    <div class="voice-visual">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>

                                    <div class="voice-status">Not recorded</div>
                                    
                                </div>
                            </div>

                            <div class="btn-group">
                                <!-- Sample Btn -->
                                <button
                                    type="button"
                                    class="btn-submit btn-sample"
                                    onclick="openSampleModal(this)"
                                >
                                    <span>View Sample</span>
                                </button>
                                <div>
                                    <!-- RECORD BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-record"
                                        onclick="startRecording(this)"
                                        title="Start Recording"
                                    >
                                        <i class="fas fa-microphone"></i>
                                    </button>

                                    <!-- STOP BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-stop"
                                        onclick="stopRecording(this)"
                                        disabled
                                        title="Stop Recording"
                                    >
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ================= Rhythm KA ================= -->
                        <div class="result-card-wrap" data-key="fileKA">
                            <div class="voice-box">
                                <div class="form-group">
                                    <label>Rhythm KA</label>

                                    <div class="voice-visual">
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>

                                    <div class="voice-status">Not recorded</div>
                                    
                                </div>
                            </div>

                            <div class="btn-group">
                                <!-- Sample Btn -->
                                <button
                                    type="button"
                                    class="btn-submit btn-sample"
                                    onclick="openSampleModal(this)"
                                >
                                    <span>View Sample</span>
                                </button>
                                <div>
                                    <!-- RECORD BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-record"
                                        onclick="startRecording(this)"
                                        title="Start Recording"
                                    >
                                        <i class="fas fa-microphone"></i>
                                    </button>

                                    <!-- STOP BUTTON -->
                                    <button
                                        type="button"
                                        class="btn-submit btn-stop"
                                        onclick="stopRecording(this)"
                                        disabled
                                        title="Stop Recording"
                                    >
                                        <i class="fas fa-stop"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="btn-wrap">
                        <button type="submit" class="btn-submit" style="max-width:250px" id="submitBtn" disabled>Submit</button>
                    </div>               
                </form>
        </div>
    </section>
    <!-- Sample File Popup -->
    <div id="voiceModal" class="auth-modal">
        <div class="auth-backdrop" onclick="closeVoiceModal()"></div>
            <div class="auth-modal-content">
                <span class="auth-close" onclick="closeVoiceModal()">&times;</span>
                <div class="auth-scroll">
                    <!-- SCROLL CONTAINER -->
                    <div class="auth-card">
                        <h3 id="voiceModalTitle">Voice Samples </h3>
                        <div class="modal-body" id="voiceModalBody">
                        <!-- Dynamic voices will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <div id="toast-container"></div>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/voice-dashboard.js"></script>
</body>
</html>
