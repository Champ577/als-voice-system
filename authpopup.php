<!-- AUTH MODAL -->
<div id="authModal" class="auth-modal">
    <div class="auth-backdrop" onclick="closeAuthModal()"></div>
    <div class="auth-modal-content">
        <span class="auth-close" onclick="closeAuthModal()">&times;</span>
        <!-- SCROLL CONTAINER -->
        <div class="auth-scroll">
            <!-- Auth Card -->
            <div class="auth-card">
                
                <!-- Login Form -->
                <form id="login-form" class="login-form">
                    <h2>Login</h2>
                    
                    <div class="form-group">
                        <label for="log_userid">Email ID<span class="mandatory">*</span></label>
                        <input type="text" id="log_userid" name="userid" placeholder="Enter your Email ID">
                        <small class="error-msg" id="error_log_userid"></small>
                    </div>

                    <div class="form-group">
                        <label for="log_pass">Password<span class="mandatory">*</span></label>
                        <input type="password" id="log_pass" name="password" placeholder="Enter Password">
                        <small class="error-msg" id="error_log_pass"></small>
                    </div>

                    <button type="submit" class="btn-submit">LOGIN</button>
                    
                    <a class="toggle-link" onclick="toggleForm('register')">
                        Don't have an account? <span>Register here</span>
                    </a>
                </form>

                <!-- Register Form (Hidden) -->
                <form id="register-form" style="display: none;" class="register-form">
                    <h2>Register</h2>                
                    <div class="form-group-list">
                        <div class="form-group w32">
                            <label for="reg_name">Name<span class="mandatory">*</span></label>
                            <input type="text" id="reg_name" name="name" placeholder="John Doe">
                            <small class="error-msg" id="error_reg_name"></small>
                        </div>

                        <div class="form-group w32">
                            <label for="reg_email">Email ID<span class="mandatory">*</span></label>
                            <input type="email" id="reg_email" name="email" placeholder="example@mail.com">
                            <small class="error-msg" id="error_reg_email"></small>
                        </div>

                        <div class="form-group w32">
                            <label for="reg_phone">Phone No<span class="mandatory">*</span></label>
                            <input type="tel" id="reg_phone" name="phone" placeholder="10 digit number" max="10" min="10">
                            <small class="error-msg" id="error_reg_phone"></small>
                        </div>

                        <div class="form-group w32">
                            <label for="reg_age">Age<span class="mandatory">*</span></label>
                            <input type="number" id="reg_age" name="age"  min="1" max="120" oninput="this.value = this.value.slice(0,3);" placeholder="Age">
                            <small class="error-msg" id="error_reg_age"></small>
                        </div>

                       

                        <div class="form-group w32">
                            <label for="reg_pass">Password<span class="mandatory">*</span></label>
                            <input type="password" id="reg_pass" name="password" placeholder="Create Password">
                            <small class="error-msg" id="error_reg_pass"></small>
                        </div>

                        <div class="form-group w32">
                            <label for="reg_confirm">Confirm Password<span class="mandatory">*</span></label>
                            <input type="password" id="reg_confirm" name="confirm_password" placeholder="Confirm Password">
                            <small class="error-msg" id="error_reg_confirm"></small>
                        </div>

                         <div class="form-group w29">
                            <label for="reg_gender">Gender<span class="mandatory">*</span></label>
                            <div class="radio-wrapper">
                                <label><input type="radio" name="gender" value="1" checked>Male</label>
                                <label><input type="radio" name="gender" value="0">Female</label>
                            </div>
                            <small class="error-msg" id="error_reg_gender"></small>
                        </div>

                        <div class="form-group w69">
                            <label for="reg_confirm">Are you suffering from any motor nervous disease?<span class="mandatory">*</span></label>
                            <div class="radio-wrapper">
                            
                                <label><input type="radio" name="disease" value="no" checked onchange="toggleDisease(this)"> No</label>
                                <label><input type="radio" name="disease" value="yes" onchange="toggleDisease(this)"> Yes</label>
                            </div>
                        </div>

                        <div id="disease-area" style="display:none;">
                            <div class="form-group-list">
                                <div class="form-group w49">
                                    <label for="diagnosis_status">Diagnosis Status<span class="mandatory">*</span></label>
                                    <select  id="diagnosis_status" name="diagnosis_status">
                                        <option value="">Select</option>
                                        <option value="Newly Diagnosed">Newly Diagnosed</option>
                                        <option value="Suspected / Under Evaluation">Suspected / Under Evaluation</option>
                                        <option value="Family History">Family History (but not diagnosed)</option>
                                    </select>
                                    <small class="error-msg" id="error_diagnosis_status"></small>
                                </div>
                                <div class="form-group w49">
                                    <label for="year_of_diagnosed">Year of diagnosed (if applicable)</label>
                                    <input type="text" id="year_of_diagnosed" name="year_of_diagnosed" placeholder="Year of diagnosed">
                                </div>
                                <div class="form-group w49">
                                    <label for="hospita_doctor_name">Hospital / Doctor where diagnosed</label>
                                    <input type="text" id="hospita_doctor_name" name="hospita_doctor_name" placeholder="Hospital / Doctor Name">
                                </div>
                                <div class="form-group w49">
                                    <label for="type_of_mnd">Type of MND (if know) - ALS, PLS, SMA, Other</label>
                                    <input type="text" id="type_of_mnd" name="type_of_mnd" placeholder="Type of MND">
                                </div>
                                <div class="form-group w100 mb-0">
                                    <label for="disease_desc">Description<span class="mandatory">*</span></label>
                                    <textarea id="disease_desc" name="disease_desc" placeholder="Please Specify..." oninput="countCharacters()"></textarea>
                                    <div style="text-align: right; font-size: 11px; color: #888; margin-top: 3px;">
                                        Words: <span id="word-count">0</span>/100
                                    </div>
                                    <small class="error-msg" id="error_disease_desc"></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group w100 consent-group">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" id="reg_consent" name="consent">
                                <span class="checkmark"></span>
                                <span class="checkbox-text">
                                    Do you give us consent to use your voice samples for research purposes?
                                </span>
                            </label>
                            <small class="error-msg" id="error_reg_consent"></small>
                        </div>

                        
                    
                    </div>

                    

                    <button type="submit" class="btn-submit" id="register">REGISTER</button>
                    
                    <a class="toggle-link" onclick="toggleForm('login')">
                        Already have an account? <span>Login here</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>