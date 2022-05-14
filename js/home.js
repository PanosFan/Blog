// functions
function fetctPosts() {
  $.ajax({
    url: "http://localhost:80/Blog/api/postsApi.php",
    method: "GET",
    success: (res) => {
      $("tbody").html("");
      res.forEach((element) => {
        $("tbody").append(
          `<tr>
            <td class="id">${element.post_id}</td>
            <td>${element.title}</td>
            <td>${element.body}</td>
            <td>${element.name}</td>
            <td>${element.surname}</td>
            <td>
            <button class="btn btn-danger">Delete</button>
          ${false ? '<button class="btn btn-danger">Delete</button>' : ""}
            </td>
          </tr>`
        );
      });
      getIndex();
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
    method: "GET",
    success: (res) => {
      $("tbody").html("");
      res.forEach((element) => {
        $("tbody").append(
          `<tr>
            <td class="id">${element.post_id}</td>
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
      getIndexByID();
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
    method: "GET",
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

function getIndex() {
  $("table .btn-danger").on("click", function () {
    let index = $("table .btn-danger").index(this);
    let idVal = document.querySelectorAll(".id");
    let check = confirm("Are you sure you want to delete that post?");
    if (!check) return false;
    $.ajax({
      url: `http://localhost:80/Blog/api/postsApi.php?id=${idVal[index].innerHTML}`,
      method: "DELETE",
      success: () => {
        fetctPosts();
      },
      error: (err) => {
        alert(err.responseJSON.error);
      },
      xhrFields: {
        withCredentials: true,
      },
    });
  });
}

function getIndexByID() {
  $("table .btn-danger").on("click", function () {
    let index = $("table .btn-danger").index(this);
    let idVal = document.querySelectorAll(".id");
    let check = confirm("Are you sure you want to delete that post?");
    if (!check) return false;
    $.ajax({
      url: `http://localhost:80/Blog/api/postsApi.php?id=${idVal[index].innerHTML}`,
      method: "DELETE",
      success: () => {
        fetchPostByID();
      },
      error: (err) => {
        alert(err.responseJSON.error);
      },
      xhrFields: {
        withCredentials: true,
      },
    });
  });
}

fetctPosts();
