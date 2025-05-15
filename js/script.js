document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        const PIN = document.querySelector("input[name='PIN']").value.trim();
        const memberName = document.querySelector("input[name='memberName']").value.trim();

        if (PIN === "" || memberName === "") {
            alert("Both fields are required!");
            event.preventDefault();
            return;
        }

        // Ensure PIN is numeric
        if (!/^\d+$/.test(PIN)) {
            alert("PIN must be a number!");
            event.preventDefault();
            return;
        }
    });
});
