$(document).ready(function () {
  // Open Search
  $('#SuggestionInput').click(function (event) {
    $('.suggestion-container-items').css('display', 'block')
    event.stopPropagation()
  })

  $('body').click(function () {
    $('.suggestion-container-items').css('display', 'none')
  })
})

function grid () {
  $('#masonry-container').masonry({
    itemSelector: '.grid-item',
    transitionDuration: '0.2s',
    stagger: '0.03s'
  })
}

$(document).imagesLoaded(function () {
  grid()
})

$(document).ready(grid())
$('.carousel').on('slid.bs.carousel', function () {
  grid()
})
