// functions
function fetctPosts() {
  $.ajax({
    url: "http://localhost:80/Blog/api/postsApi.php",
    type: "GET",
    success: (res) => {
      $("tbody").html("");
      console.log(res);
      res.forEach((element) => {
        $("tbody").append(
          `<tr>
            <td>${element.post_id}</td>
            <td>${element.title}</td>
            <td>${element.body}</td>
            <td>${element.name}</td>
            <td>${element.surname}</td>
            <td>
              <button class="btn btn-danger">Delete</button>
            </td>
          </tr>`
        );
      });
    },
    error: (err) => {
      alert(err.responseJSON.error);
    },
    xhrFields: {
      withCredentials: true,
    },
  });
}

function fetchPostByID() {
  $.ajax({
    url: `http://localhost:80/Blog/api/postsApi.php?user=${$(
      "#searchVal"
    ).val()}`,
    type: "GET",
    success: (res) => {
      $("tbody").html("");
      console.log(res);
      res.forEach((element) => {
        $("tbody").append(
          `<tr>
            <td>${element.post_id}</td>
            <td>${element.title}</td>
            <td>${element.body}</td>
            <td>${element.name}</td>
            <td>${element.surname}</td>
            <td>
              <button class="btn btn-danger">Delete</button>
            </td>
          </tr>`
        );
      });
    },
    error: (err) => {
      alert(err.responseJSON.error);
    },
    xhrFields: {
      withCredentials: true,
    },
  });
}
// end of functions

// event listeners
$("#search").submit((e) => {
  e.preventDefault();
  fetchPostByID();
});

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
// end of event listeners

fetctPosts();
