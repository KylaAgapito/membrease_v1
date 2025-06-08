document.addEventListener("DOMContentLoaded", () => {

    const dashboard = document.querySelector(".dashboard");
    let originalMarkup = dashboard.innerHTML; // save initial content

    
  
    // Apply overflow if on update page
    if (document.body.classList.contains("update-page")) {
      dashboard.style.overflow = "auto";
    }
  
    // Initially attach update button listener
    const updateBtn = dashboard.querySelector(".update-button");
    if (updateBtn) {
      updateBtn.addEventListener("click", enterEditMode);
    }
  
    function enterEditMode() {
      dashboard.style.overflow = "auto"; // ensure overflow when editing
      dashboard.innerHTML = `
        <div class="section-4">
  
          <div class="update-information">
            <div class="update-information-title">Update your information below:</div>
  
            <div class="update-information-list">
  
              <div class="update-member-information">
                <p>Member Information</p>
  
                <div class="update-name">
                  <div>Member Name:</div>
                  <input type="text" />
                </div>
  
                <div class="update-birthdate">
                  <div>Birthdate:</div>
                  <input type="date" />
                </div>
  
                <div class="birthplace">
                  <div>Birthplace:</div>
                  <input type="text" />
                </div>
  
                <div class="sex">
                  <div>Sex:</div>
                  <div class="sex-input">
                    <div class="options">
                      <label><input type="radio" name="gender" value="male" /> Male</label>
                      <label><input type="radio" name="gender" value="female" /> Female</label>
                    </div>
                  </div>
                </div>
  
                <div class="civil-status">
                  <div>Civil Status:</div>
                  <div class="civil-status-input">
                    <div class="options">
                      <label><input type="radio" name="civil-status" value="S" /> Single</label>
                      <label><input type="radio" name="civil-status" value="M" /> Married</label>
                      <label><input type="radio" name="civil-status" value="W" /> Widowed</label>
                      <label><input type="radio" name="civil-status" value="A" /> Annulled</label>
                      <label><input type="radio" name="civil-status" value="LS" /> Legally Separated</label>
                    </div>
                  </div>
                </div>
  
                <div class="citizenship">
                  <div>Citizenship:</div>
                  <input type="text" />
                </div>
  
                <div class="address">
                  <div>Address:</div>
                  <input type="text" />
                </div>
  
                <div class="mailing-address">
                  <div>Mailing Address:</div>
                  <input type="text" />
                </div>
  
                <div class="mother-name">
                  <div>Mother's name:</div>
                  <input type="text" />
                </div>
  
              </div>
  
              <div class="update-contact-information">
                <p>Contact Information</p>
  
                <div class="contact-number">
                  <div>Home Phone Number:</div>
                  <input type="tel" />
                </div>
  
                <div class="direct-number">
                  <div>Direct Number:</div>
                  <input type="tel" />
                </div>
  
                <div class="email-address">
                  <div>Email Address:</div>
                  <input type="email" />
                </div>
              </div>
  
              <div class="update-spouse-information">
                <p>Spouse Information</p>
  
                <div class="spouse-name">
                  <div>Spouse Name:</div>
                  <input type="text" />
                </div>
              </div>
            </div>
  
          </div>
  
          <div style="display:flex; justify-content: space-between;">
            <button class="cancel-button">Cancel</button>
            <button class="save-button">Update</button>
          </div>
        </div>
      `;
  
      // Attach Cancel button event to revert to original
      dashboard.querySelector(".cancel-button").addEventListener("click", exitEditMode);
    }
  
    function exitEditMode() {
      dashboard.innerHTML = originalMarkup;
      dashboard.style.overflow = ""; // reset overflow
  
      // Re-query the update button (new element after innerHTML reset) and attach listener
      const newUpdateBtn = dashboard.querySelector(".update-button");
      if (newUpdateBtn) {
        newUpdateBtn.addEventListener("click", enterEditMode);
      }
    }
  });
  