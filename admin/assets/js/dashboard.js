var process_url = base_url + "/admin/process";
$(document).ready(function () {
  $(document).on("click", "#dashboard_search", function () {
    load_graph();
  });

  function load_graph() {
    $value = $("#dashboard-time-range").val();
    $.ajax({
      url: process_url,
      method: "post",
      data: {
        value: $value,
        action: "dashboard_graph",
      },
      success: function (response) {
        $("#cs_date").html($value);
        $("#dashboard_graph_container").html(response);
      },
    });
  }
 
  updateConfig();
  function updateConfig() {
    var options = {};

    options = {
      minDate: "01 Februray, 2021",
      maxDate: moment(),
      opens: "left",
    };

    options.ranges = {
      "Last 7 Days": [moment().subtract(6, "days"), moment()],
      "Last 30 Days": [moment().subtract(29, "days"), moment()],
      "This Month": [moment().startOf("month"), moment().endOf("month")],
      "Last Month": [
        moment().subtract(1, "month").startOf("month"),
        moment().subtract(1, "month").endOf("month"),
      ],
    };

    options.locale = {
      direction: $("#rtl").is(":checked") ? "rtl" : "ltr",
      format: "D MMMM, YYYY",
      separator: " - ",
      applyLabel: "Apply",
      cancelLabel: "Cancel",
      fromLabel: "From",
      toLabel: "To",
      customRangeLabel: "Custom",
      daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
      monthNames: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ],
      firstDay: 1,
    };
    $("#dashboard-time-range").daterangepicker(
      options
    );
    $("#pin-time-range").daterangepicker(
      options
    );
    $("#joining-time-range").daterangepicker(
      options
    );

    $("#income-time-range").daterangepicker(
       options
    );
  }
});


$(document).on("click", "#block_user", function () {
  $this = $(this);
  $user_id = $this.attr("data-id");
  $.ajax({
    url: process_url,
    method: "post",
    data: {
      action: "change_user_status",
      condition: "block",
      user_id: $user_id,
    },
    beforeSend: function () {},
    success: function () {
      $this
        .parent()
        .parent()
        .parent()
        .siblings("td")
        .find(".label")
        .html("block")
        .removeClass("label-success")
        .addClass("label-danger");
    },
  });
});

$(document).on("click", "#unblock_user", function () {
  $this = $(this);
  $user_id = $this.attr("data-id");
  $.ajax({
    url: process_url,
    method: "post",
    data: {
      action: "change_user_status",
      condition: "unblock",
      user_id: $user_id,
    },
    beforeSend: function () {},
    success: function () {
      $this
        .parent()
        .parent()
        .parent()
        .siblings("td")
        .find(".label")
        .html("active")
        .removeClass("label-danger")
        .addClass("label-success");
    },
  });
});

$(document).on("click", "#support_cards_container .card", function () {
  $this = $(this);
  $("#support_cards_container .card").removeClass("active-support-card");
  $this.addClass("active-support-card");
  $target = $this.attr("target");
  $(".support_tbl_body").hide();
  $target = $("#" + $target);
  $target.show();
});

$(document).on("submit", "#admin_add_reply_to_ticket", function () {
  event.preventDefault();
  $this = $(this);
  $files = uploadfiles;
  $formdata = $this.serialize();
  $ticket_id = $this.attr("ticket-id");
  $.ajax({
    url: process_url,
    method: "post",
    data:
      $formdata +
      "&action=admin_reply_to_ticket&files=" +
      $files +
      "&ticket_id=" +
      $ticket_id,
    beforeSend: function () {
      disable_form($this);
    },
    success: function ($response) {
      if (isHtml($response)) {
        reset_form($this);
        $("#tickets_container").prepend($response);
        sweetalert_redirect("success", "Replied added successfully", base_url+'/admin/support/', "href");
      } else {
        sweetalert("error", $response);
      }
    },
    error: function () {
      sweetalert("error", "Something went wrong");
    },
    complete: function () {
      enable_form($this);
    },
  });
});

$(document).on("click", "#admin_close_ticket_btn", function () {
  $this = $(this);
  $.ajax({
    url: process_url,
    method: "post",
    data: {
      ticket_id: ticket_id,
      action: "admin_close_ticket",
    },
    beforeSend: function () {
      $(this).attr("disabled", true).html("Please wait...").css({
        opacity: ".2",
        cursor: "not-allowed",
      });
    },
    success: function (response) {
      if (response == "Ticket closed successfully") {
        sweetalert_redirect(
          "success",
          response,
          base_url + "/admin/support/",
          "href"
        );
      } else {
        sweetalert("error", response);
      }
    },
    error: function () {
      sweetalert("error", "Something went wrong");
    },
    complete: function () {
      $this.attr("disabled", false).html("Close ticket").css({
        opacity: "1",
        cursor: "pointer",
      });
    },
  });
});

$(document).on("click", "#pin_search", function () {
  $value = $("#pin-time-range").val();
  $.ajax({
    url: process_url,
    method: "post",
    data: {
      value: $value,
      action: "load_pin_graph",
    },
    success: function ($response) {
        $("#cs_date").html($value);
        load_pin_page($value);
      $("#pin_graph_container").html($response);
    },
  });
});

function load_pin_page($value) {
  $.ajax({
    url: process_url,
    method: "post",
    data: {
      value: $value,
      action: "load_pin_page",
    },
    success: function ($response) {
      $("#e_pin_update").html($response);
    },
  });
}

$(document).on("click", "#ticket-dropdown a:nth-child(1)", function () {
  $("#support_cards_container").find(".ticket-all").hide();
  $("#support_cards_container").find(".ticket-today").show();
});

$(document).on("click", "#ticket-dropdown a:nth-child(2)", function () {
  $("#support_cards_container").find(".ticket-all").show();
  $("#support_cards_container").find(".ticket-today").hide();
});

$(document).on("click", "#income_search", function () {
  $value = $("#income-time-range").val();
  $.ajax({
    url: process_url,
    method: "post",
    data: {
      value: $value,
      action: "load_income_graph",
    },
    success: function ($response) {
        $("#cs_date").html($value);
      $("#income_graph_container").html($response);
    },
  });
});
$(document).on("click", "#joining_search", function () {
  $value = $("#joining-time-range").val();
  $.ajax({
    url: process_url,
    method: "post",
    data: {
      value: $value,
      action: "load_joining_graph",
    },
    success: function ($response) {
      $("#cs_date").html($value);
      $("#joining_graph_container").html($response);
    },
  });
});



  // function get_from_to_date($data) {
  //   $months = [
  //     "",
  //     "January",
  //     "February",
  //     "March",
  //     "April",
  //     "May",
  //     "June",
  //     "July",
  //     "August",
  //     "September",
  //     "October",
  //     "November",
  //     "December",
  //   ];

  //   $data = $data.split("-");

  //   $from_date = $data[0];
  //   $from_date = $from_date.split("/");
  //   $fd = $from_date[0];
  //   $fm = $from_date[1];
  //   $fy = $from_date[2];
  //   $from_date = new Date($fy, $fm, $fd);
  //   $from_day = $from_date.getDate();
  //   $from_month = $months[$from_date.getMonth()];
  //   $from_year = $from_date.getFullYear();
  //   $from_out = $from_day + " " + $from_month + " " + $from_year;

  //   $to_date = $data[1];
  //   $to_date = $to_date.split("/");
  //   $td = $to_date[0];
  //   $tm = $to_date[1];
  //   $ty = $to_date[2];
  //   $to_date = new Date($ty, $tm, $td);
  //   $to_day = $to_date.getDate();
  //   $to_month = $months[$to_date.getMonth()];
  //   $to_year = $to_date.getFullYear();
  //   $to_out = $to_day + " " + $to_month + " " + $to_year;
  //   return $from_out + " - " + $to_out;
  // }


  $(document).on("click", 'input[type=radio][name=payment_method]',function(){
    $("#approve_withdraw").attr('disabled',false);
  });

  $(document).on("click", "#approve_withdraw", function () {
    $this = $(this);
    if(!$("input[type=radio][name=payment_method]").is(':checked')){
      sweetalert("error", "Please select a payment method");
    }else{
      $payment_method = $("input[type=radio][name=payment_method]:checked").val();
     $.ajax({
       url: process_url,
       method: "post",
       data: {
         withdraw_id: withdraw_id,
         payment_method: $payment_method,
         action: "approve_withdraw",
       },
       beforeSend: function () {
         $this
           .attr("disabled", true)
           .html("Please Wait...")
           .css({ opacity: ".5", cursor: "not-allowed" });
       },
       success: function ($response) {
         if ($response == "Withdraw approved") {
           sweetalert_redirect(
             "success",
             $response,
             base_url + "/admin/wallet/payout.php",
             "replace"
           );
         } else {
           sweetalert("error", $response);
         }
       },
       error: function () {
         sweetalert("error", "Something went wrong");
       },
       complete: function () {
         $this
           .attr("disabled", false)
           .html("Approve")
           .css({ opacity: "1", cursor: "pointer" });
       },
     });
    }
  });


 $(".table-responsive.res").on("show.bs.dropdown", function () {
   $(".table-responsive").css("overflow", "inherit");
 });

 $(".table-responsive.res").on("hide.bs.dropdown", function () {
   $(".table-responsive").css("overflow", "auto");
 });
 


 $(document).on("submit", "#admin_login_form",function(){
   event.preventDefault();
   $element = $(this);
    var keeploggedin;
    if ($("input.remember_me").is(":checked")) {
      keeploggedin = 1;
    } else {
      keeploggedin = 0;
    }
   $formdata = $element.serialize();
   $.ajax({
     url: process_url,
     method: "post",
     data: $formdata + "&action=admin_login&keeploggedin=" + keeploggedin,
     beforeSend: function () {
       disable_form($element);
     },
     success: function (response) {
       if (response == "Login successfull") {
         sweetalert_redirect(
           "success",
           response,
           base_url + "/admin/dashboard/",
           "replace"
         );
       } else {
         sweetalert("error", response);
       }
     },
     error: function () {
       sweetalert("error", "Something went wrong");
     },
     complete: function () {
       enable_form($element);
     },
   });
 });