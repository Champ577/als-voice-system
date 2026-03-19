function toggleSidebar(){
  sidebar.classList.toggle('show');
  sidebarOverlay.classList.toggle('show');
}

function toggleUserMenu(){
  document.getElementById('userDropdown').classList.toggle('show');
}

 function openVoiceModal(userId) {
    const modal = document.getElementById('voiceModal');
    const body  = document.getElementById('voiceModalBody');
    modal.style.display = 'flex';
    body.innerHTML = '<p style="text-align:center">Loading voices...</p>';
    fetch('get_user_voices.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_id: userId }),
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(resp => {
        if (!resp.status) {
            body.innerHTML = `<p style="color:red;text-align:center">${resp.message}</p>`;
            return;
        }
        let html = '';

        resp.voices.forEach(v => {
            const badgeClass = resp.prediction === 'ALS' ? 'warning' : 'success';
            const badgeText  = resp.prediction === 'ALS' ? 'Mild Issue' : 'No Disability';

            html += `
                <div class="voice-row">
                    <div class="voice-info">

                        <div class="voice-meta">
                        <span class="voice-name">${v.label}</span>

                        <audio controls>
                            <source src="${v.file}" type="audio/wav">
                        </audio>
                        </div>

                        <span class="badge ${badgeClass}">
                        ${badgeText}
                        </span>
                    </div>

                    <a
                        href="${v.file}"
                        download
                        class="download-btn"
                        title="Download Voice"
                    >
                        <i class="fas fa-download"></i>
                    </a>
                    </div>

            `;
        });

        if (!html) {
            html = `<p style="text-align:center;color:#888">No voice samples uploaded.</p>`;
        }

        body.innerHTML = html;
    })
    .catch(() => {
        body.innerHTML = '<p style="color:red;text-align:center">Server error</p>';
    });
}

function closeVoiceModal() {
    document.getElementById('voiceModal').style.display = 'none';
}


// Sidebar active link handler
document.addEventListener('DOMContentLoaded', () => {
  // Get current file name from URL
  let currentPage = window.location.pathname.split('/').pop();

  // Fallback: if URL ends with /admin/ then treat as index.php
  if (!currentPage || currentPage === '') {
    currentPage = 'index.php';
  }

  const links = document.querySelectorAll('.sidebar nav a');

  links.forEach(link => {
    link.classList.remove('active');

    const linkPage = link.getAttribute('href');

    if (linkPage === currentPage) {
      link.classList.add('active');
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const currentPath = window.location.pathname;
  document.querySelectorAll('.sidebar nav a').forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add('active');
    }
  });
});


/* --- TOASTER SYSTEM --- */
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    const icon = type === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>';
    
    toast.className = `toast ${type}`;
    toast.innerHTML = `${icon} <span>${message}</span>`;
    
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease forwards';
        toast.addEventListener('animationend', () => toast.remove());
    }, 3000);
}

// Show Error on field
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorText = document.getElementById('error_' + fieldId);

    field.classList.add('error');
    errorText.textContent = message;
    errorText.classList.add('show');

    if (document.activeElement !== field) {
        field.focus();
    }

    return false;
}



// 1. LOGIN VALIDATION
document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.getElementById('login-form');
    if (loginForm) {
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();    
    const userid = document.getElementById('log_userid').value.trim();
    const pass = document.getElementById('log_pass').value.trim();
    // Step-by-Step Validation
    if (!userid) return showError('log_userid', 'Email ID is required.');
    if (!pass) return showError('log_pass', 'Password is required.');

    // If valid, proceed to AJAX
    clearAllErrors('login-form');
    const formData = new FormData();
    formData.append('userid', userid);
    formData.append('password', pass);    
    fetchAjax(formData, '../login.php', 'login');
});
}
});


/* --- STATE TRANSITION --- */
function handleLoginSuccess() {
    setTimeout(() => {
        window.location.href = 'admin/';
    }, 1000);
}

function handleLogout() {
    window.location.href = 'index.php';
}

// Clear all errors on form toggle
function clearAllErrors(formId) {
    document.getElementById(formId).querySelectorAll('.form-group input, .form-group textarea').forEach(el => {
        el.classList.remove('error');
    });
    document.querySelectorAll('.error-msg').forEach(el => el.classList.remove('show'));
}

function showLoader() {
    const loader = document.getElementById('ajaxLoader');
    if (loader) {
        loader.style.display = 'flex';
    }
}

function hideLoader() {
    const loader = document.getElementById('ajaxLoader');
    if (loader) {
        loader.style.display = 'none';
    }
}
function fetchAjax(formData, phpUrl, type) {
    showLoader();
    fetch(phpUrl, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(response => {
        console.log('AJAX RESPONSE:', response); // DEBUG
        if (!response.status) {
            showToast(response.message || 'Something went wrong', 'error');
            if (response.field) {
                const field = document.getElementById(response.field);
                if (field) {
                    field.classList.add('error');
                    field.focus();
                }
            }
            return;
        }
        if (response.redirect !== undefined) {
            setTimeout(() => {
                if (response.redirect == 1) {
                    showToast(response.message || 'Success', 'success');
                    window.location.href = 'dashboard.php';
                }else{
                    showToast('Invalid User ID or Password', 'error');
                }
            }, 500);
            return;
        }


        if (type === 'login') {
            handleLoginSuccess();
        } else {
            toggleForm('login');
        }
    })
    .catch(err => {
        console.error(err);
        showToast('Server error. Please try again later.', 'error');
    })
    .finally(() => {
        hideLoader();
    });
}