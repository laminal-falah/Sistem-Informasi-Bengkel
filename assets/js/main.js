var http = $('meta[name="url"]').attr('content');

function showLoading() {
  $('div#loading').show().html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
}

function hideLoading() {
  $('div#loading').hide();
  $('div#loading').empty();
}

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

$(function () {
  showLoading();

  function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 1000);

    function checkReady() {
      if (document.getElementsByTagName('body')[0] !== undefined) {
        window.clearInterval(intervalID);
        callback.call(this);
      }
    }
  }

  onReady(function () {
    hideLoading();
  });

  setInterval(function () {
    var currentTime = new Date();
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();
    var seconds = currentTime.getSeconds();

    // Add leading zeros
    minutes = (minutes < 10 ? "0" : "") + minutes;
    seconds = (seconds < 10 ? "0" : "") + seconds;
    hours = (hours < 10 ? "0" : "") + hours;

    // Compose the string for display
    var currentTimeString = hours + ":" + minutes + ":" + seconds;
    $("#clock").html(currentTimeString);

  }, 1000);

  var year = $('#year-copy');
  var d = new Date();
  if (d.getFullYear() == '2019') {
    year.html('2019');
  } else {
    year.html('2019-' + d.getFullYear().toString());
  }

  $('#navigation').find('a.menu').on('click', function () {
    var page = $(this).attr('href');
    $.ajax({
      beforeSend: function () {
        showLoading();
      },
      success: function (response) {
        window.location.href = page;
      }
    });
  });

  $('#account').find('a').on('click', function () {
    var page = $(this).attr('href');
    $.ajax({
      beforeSend: function () {
        showLoading();
      },
      success: function (response) {
        window.location.href = page;
      }
    });
  });
});