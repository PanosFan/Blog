$("#logoutButton").click(() => {
  $.ajax({
    url: "http://localhost:80/Blog/api/loginApi.php",
    type: "GET",
    success: () => {
      $(location).prop("href", "http://localhost:5500/index.html");
    },
    error: (err) => {
      alert(err.responseJSON.error);
    },
    xhrFields: {
      withCredentials: true,
    },
  });
});
