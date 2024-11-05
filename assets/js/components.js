const myForm = document.querySelector("form");

myForm.addEventListener("submit", async function (event) {
  event.preventDefault();

  const formData = new FormData(myForm);
  const actionUrl = myForm.action;

  const submitButton = myForm.querySelector("button[type='submit']");
  submitButton.disabled = true;
  submitButton.textContent = "Submitting...";

  try {
    const response = await fetch(actionUrl, {
      method: "POST",
      body: formData,
    });

    if (response.status === 200) {
      const result = await response.json();

      if (result.status === "success") {
        if (result.redirect) {
          window.location.href = result.redirect;
        } else {
          alert("Success: " + result.message);
          myForm.reset();
        }
      } else {
        alert("Error: " + result.message);
      }
    } else {
      const errorText = await response.text();
      console.error("Server error:", errorText);
      alert("Error: An issue occurred on the server. Please try again later.");
    }
  } catch (error) {
    console.error("Network error:", error);
    alert(
      "Network error: Please check your internet connection and try again."
    );
  } finally {
    submitButton.disabled = false;
    submitButton.textContent = "Submit";
  }
});
fetch("../classes/auth.class.php")
  .then((response) => response.json())
  .then((data) => {
    if (data.sessionActive) {
      console.log(data.data);
    } else {
      console.log("No session active");
    }
  })
  .catch((error) => {
    console.error("Error:", error);
  });
