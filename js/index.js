$("#loginForm").submit((e) => {
  e.preventDefault();
  $.ajax({
    url: "http://localhost:80/Blog/api/loginApi.php",
    type: "POST",
    data: JSON.stringify({
      email: $("#loginEmail").val(),
      password: $("#loginPassword").val(),
    }),
    success: () => {
      $(location).prop("href", "http://localhost:5500/home.html");
      $("#loginEmail").val("");
      $("#loginPassword").val("");
    },
    error: (err) => {
      alert(err.responseJSON.error);
    },
    xhrFields: {
      withCredentials: true,
    },
  });
});

$("#signupForm").submit((e) => {
  e.preventDefault();
  $.ajax({
    url: "http://localhost:80/Blog/api/signupApi.php",
    type: "POST",
    data: JSON.stringify({
      name: $("#signupName").val(),
      surname: $("#signupSurname").val(),
      email: $("#signupEmail").val(),
      password: $("#signupPassword").val(),
      repeat_password: $("#signupPasswordR").val(),
    }),
    success: () => {
      $(location).prop("href", "http://localhost:5500/home.html");
      $("#signupName").val("");
      $("#signupSurname").val("");
      $("#signupEmail").val("");
      $("#signupPassword").val("");
      $("#signupPasswordR").val("");
    },
    error: (err) => {
      alert(err.responseJSON.error);
    },
    xhrFields: {
      withCredentials: true,
    },
  });
});
