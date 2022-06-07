(function ($, Drupal) {
  // I want some code to run on page load, so I use Drupal.behaviors
  Drupal.behaviors.scroll = {
    attach: function (context, settings) {
      window.onscroll = function() {
        var e = document.getElementById("scrolltop");
        if (!e) {
          e = document.createElement("a");
          e.id = "scrolltop";
          e.href = "#";
          document.body.appendChild(e);
        }
        e.style.display = document.documentElement.scrollTop > 300 ? "block" : "none";
        e.onclick = (ev) => {
          ev.preventDefault();
          document.documentElement.scrollTop = 0;
        };
      };
    }
  };
}(jQuery, Drupal));
