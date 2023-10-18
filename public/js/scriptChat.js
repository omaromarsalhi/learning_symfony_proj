function sendMsg() {
  var bd = $("#sentMsg").val();
  $.ajax({
    url: "/chat/save",
    type: "POST",
    data: {
      body: bd,
    },
    async: true,
    dataType: "json",
    success: function (response) {
      console.log(response.chat);
      if (response.result == "success") {
        $("#chatBody").append(
          `<div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-right">` +
            response.user.firstName +
            " " +
            response.user.lastName +
            `</span>
          <span class="direct-chat-timestamp pull-left">` +
            response.chat.sentAt +
            `</span>
        </div>

        <img class="direct-chat-img" src="../uploads/` +
            response.user.image +
            `" alt="message user image">

        <div class="direct-chat-text">
          ` +
            bd +
            `
        </div>

      </div>
      <div class="direct-chat-msg">
									<div class="direct-chat-info clearfix">
										<span class="direct-chat-name pull-left">Timona Siera</span>
										<span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
									</div>

									<img class="direct-chat-img" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="message user image">

									<div class="direct-chat-text">
										For what reason would it be advisable for me to think about business content?
									</div>

								</div>`
        );
      } else {
        alert(response);
      }
    },
  });
}
