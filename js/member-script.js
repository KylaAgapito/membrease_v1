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
      dashboard.style.overflow = "auto";
      dashboard.innerHTML = `
        <div class="section-4">
          <div class="update-information">
            <div class="update-information-title">Update your information below:</div>
            <div class="update-information-list">
              <div class="update-member-information">
                <p>Member Information</p>
                <div class="update-name">
                  <div>Member Name:</div>
                  <input type="text" name="memberName" />
                </div>
                <div class="update-birthdate">
                  <div>Birthdate:</div>
                  <input type="date" name="birthdate" />
                </div>
                <div class="birthplace">
                  <div>Birthplace:</div>
                  <input type="text" name="birthplace" />
                </div>
                <div class="sex">
                  <div>Sex:</div>
                  <div class="sex-input">
                    <div class="options">
                      <label><input type="radio" name="sex" value="M" /> Male</label>
                      <label><input type="radio" name="sex" value="F" /> Female</label>
                    </div>
                  </div>
                </div>
                <div class="civil-status">
                  <div>Civil Status:</div>
                  <div class="civil-status-input">
                    <div class="options">
                      <label><input type="radio" name="civilStatus" value="S" /> Single</label>
                      <label><input type="radio" name="civilStatus" value="M" /> Married</label>
                      <label><input type="radio" name="civilStatus" value="W" /> Widowed</label>
                      <label><input type="radio" name="civilStatus" value="A" /> Annulled</label>
                      <label><input type="radio" name="civilStatus" value="LS" /> Legally Separated</label>
                    </div>
                  </div>
                </div>
                <div class="citizenship">
                  <div>Citizenship:</div>
                  <input type="text" name="citizenship" />
                </div>
                <div class="address">
                  <div>Address:</div>
                  <input type="text" name="permaHomeAddress" />
                </div>
                <div class="mailing-address">
                  <div>Mailing Address:</div>
                  <input type="text" name="mailingAddress" />
                </div>
                <div class="mother-name">
                  <div>Mother's name:</div>
                  <input type="text" name="motherMaidenName" />
                </div>
              </div>
              <div class="update-contact-information">
                <p>Contact Information</p>
                <div class="contact-number">
                  <div>Home Phone Number:</div>
                  <input type="tel" name="homePhoneNo" />
                </div>
                <div class="mobile-number">
                  <div>Mobile Number:</div>
                  <input type="tel" name="mobileNo" />
                </div>
                <div class="direct-number">
                  <div>Direct Number:</div>
                  <input type="tel" name="directNo" />
                </div>
                <div class="email-address">
                  <div>Email Address:</div>
                  <input type="email" name="emailAdd" />
                </div>
              </div>
              <div class="update-spouse-information">
                <p>Spouse Information</p>
                <div class="spouse-name">
                  <div>Spouse Name:</div>
                  <input type="text" name="spouseName" />
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

      // Cancel button event
      dashboard.querySelector(".cancel-button").addEventListener("click", exitEditMode);

      // Save button event
      dashboard.querySelector(".save-button").addEventListener("click", function(e) {
        e.preventDefault();

        // Collect form data
        const getInputValue = (name, isChecked = false) => {
          const selector = isChecked ? `input[name="${name}"]:checked` : `input[name="${name}"]`;
          const element = dashboard.querySelector(selector);
          return element ? element.value : null;
        };

        const data = {
          memberName: getInputValue("memberName"),
          birthdate: getInputValue("birthdate"),
          birthplace: getInputValue("birthplace"),
          sex: getInputValue("sex", true),
          civil_status: getInputValue("civilStatus", true) || "",
          citizenship: getInputValue("citizenship"),
          address: getInputValue("permaHomeAddress"),
          mailing_address: getInputValue("mailingAddress"),
          mother_name: getInputValue("motherMaidenName"),
          home_phone: getInputValue("homePhoneNo"),
          mobile_number: getInputValue("mobileNo"),
          direct_number: getInputValue("directNo"),
          email_address: getInputValue("emailAdd"),
          spouse_name: getInputValue("spouseName"),
          update_member: true
        };

        fetch('update.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(response => {
          console.log(response);
          alert(response.message);
          if (response.success) {
            exitEditMode();
          }
        })
        .catch(error => {
          console.error(error);
          alert('Error updating information.');
        });
      });
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