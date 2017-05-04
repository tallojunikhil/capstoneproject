</section>
</div>
</div>

<div class="footer text-center" style="background: none">
    <div class="founders container-fluid">
        <ul class="text-center list-unstyled list-inline">
            <li>Built by: </li>
            <li><a href="#/">Mr. Raja Sai</a></li>
            <li><a href="#/">Talloju Nikhil</a></li>
            <li><a href="http://vpenugonda.github.io/">Sid</a></li>
        </ul>
        <ul class="text-center list-unstyled list-inline">
            <li> In love with - </li>
            <li> HTML5, CSS, JavaScript, bootstrap, <strong>Functional Programming </strong></li>
        </ul>
        <div class="text-muted">&copy; Fairfield University - Class of 2017</div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
   (function($){
      var recapQuestion = $('.question-recap');
      $('#see-more').on('click', function(e){
         e.preventDefault();
         console.log(recapQuestion.hasClass('seen'));
         if(!recapQuestion.hasClass('h-auto')){
            recapQuestion.addClass('h-auto');
            $(this).text('See Less');
         }

         else if(recapQuestion.hasClass('h-auto')){
            recapQuestion.removeClass('h-auto');
            $(this).text('See More ...');
         }
      });
   })(jQuery);

</script>
</body>
</html>