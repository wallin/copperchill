<button id="impulse">1000imp / kWh</button>

imps/h <span id="result">-</span>


<p id="history">
</p>
<script type="text/javascript">
  $(function() {
    var imps = 0;
    var avg = 0;
    var start = (new Date()).getTime();
    $('#impulse').click(function() {
      imps++;
      if (imps < 2) return;
      var time = ((new Date()).getTime() - start) / 1000;
      avg = imps / (time / 3600);
      $('#result').text(parseInt(avg));
    });


    var send = (function() {
      var count = 0;
      return function () {
        if (count++ % 10 === 0) $('#history').empty();

        $('#history').append(parseInt(avg)+'<br>');
        $('#result').text('-');
        imps = 0;
        avg = 0;
        start = (new Date()).getTime();
      };
    }());

    var randClick = function () {
      $('#impulse').click()
      setTimeout(randClick, 1000 + Math.random()*2000);
    };

    setInterval(send, 10000);

    randClick();

  });
</script>
