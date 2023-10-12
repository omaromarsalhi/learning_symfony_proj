// OMAR SALHI  IS THE OWNER OF THIS PIECE OF USELESS CODE

$(document).ready(function () {
  DisplayTableMenu();
});

function DisplayTableMenu() {
  $.ajax({
    url: "/user/show",
    type: "post",
    dataType: "json",
    success: function (response) {
      var projectRow = "";
      for (var i = 0; i < response.length; i++) {
        projectRow +=
          `<tr>
              <th scope="row">` +
          response[i].id +
          `</th>
              <td><img src="/uploads/` +
          response[i].image +
          `" alt="" width=70></td>
              <td>` +
          response[i].role[0] +
          `</td>
              <td>` +
          response[i].firstName +
          `</td>
              <td>` +
          response[i].lastName +
          `</td>
              <td>` +
          response[i].email +
          `</td>
              <td>` +
          response[i].age +
          `</td>
              <td>` +
          response[i].cin +
          `</td>
              <td class="btnContainer">
                  <button class="btn btn-danger " onClick=deletUser(` +
          response[i].id +
          `)><i class="fa-solid fa-user-minus bntOnHover"></i></button>
                  <a class="btn btn-light " href="/user/update/` +
          response[i].id +
          `"><i class="fa-regular fa-pen-to-square bntOnHover"></i></a>
              </td>
          </tr>`;
      }
      $("#tableUser").html(projectRow);
    },
    error: function (response) {
      console.log(response.responseJSON);
    },
  });
}

function deletUser(id) {
  $.ajax({
    url: "/user/delete",
    type: "POST",
    data: {
      id: id,
    },
    success: function (response) {
      if (response == "success") {
        DisplayTableMenu();
      } else {
        alert("something went wrong");
      }
    },
  });
}

// function createUser() {
//   $.ajax({
//     url: "/user/create",
//     type: "POST",
//     data: {
//       id: id,
//     },
//     success: function (response) {
//       if (response == "success") {
//         DisplayTableMenu();
//       } else {
//         alert("something went wrong");
//       }
//     },
//   });
// }
