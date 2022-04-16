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

$("#createPostForm").submit((e) => {
  e.preventDefault();
  $.ajax({
    url: "http://localhost:80/Blog/api/postsApi.php",
    type: "POST",
    data: JSON.stringify({
      title: $("#title").val(),
      body: $("#floatingTextarea").val(),
    }),
    success: () => {
      $(location).prop("href", "http://localhost:5500/home.html");
      $("#title").val("");
      $("#floatingTextarea").val("");
    },
    error: (err) => {
      alert(err.responseJSON.error);
    },
    xhrFields: {
      withCredentials: true,
    },
  });
});
