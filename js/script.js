document.querySelector("form").addEventListener("submit", function(event) {
    const name = document.querySelector("input[name='name']").value.trim();
    const email = document.querySelector("input[name='email']").value.trim();
    
    if (name === "" || email === "") {
        alert("All fields are required!");
        event.preventDefault();
    }
});
