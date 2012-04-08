<button id="impulse">Add imp</button>
<br>
current consumption: <span id="result">-</span>W


<p id="history">
</p>
<script type="text/javascript">
  $(function() {
    var curr_consumption = 0;
    var last_imp_time = null

    // Period data
    var avg_consumption = 0;
    var nbr_samples = 0;
    var last_start_time = (new Date()).getTime();

    // Register impulse and calculate current consumption
    $('#impulse').click(function() {
      time = (new Date()).getTime();
      // If first observation, wait until next
      if (last_imp_time !== null) {
        curr_consumption = (3.6e6 / (time - last_imp_time));
        nbr_samples++;
      }
      // Add consumption to current average
      avg_consumption += curr_consumption;
      last_imp_time = time;

      $('#result').text(parseInt(curr_consumption));
    });


    // Calculate and send average consumption for period
    var send = (function() {
      var count = 0;
      return function () {
        if (count++ % 10 === 0) $('#history').empty();

        avg = nbr_samples === 0 ? 0 : Math.round(avg_consumption / nbr_samples);
        $('#history').append(avg + '<br>');
        period_time = ((new Date()).getTime() - last_start_time) / 1000;

        // Reset data
        avg_consumption = 0;
        nbr_samples = 0;
        last_start_time = (new Date()).getTime();
      };
    }());

    var randClick = function () {
      $('#impulse').click()
      setTimeout(randClick, 1000 + Math.random()*2000);
    };

    // Sample period
    setInterval(send, 10000);

    randClick();

  });
</script>
