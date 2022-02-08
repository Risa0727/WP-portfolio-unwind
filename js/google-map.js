jQuery( function($) {
  console.log('最初のinfo:');
  console.log(info);


  $('.gmap-btn').on('click', function(event){
    let cat = $(this).data('cat');

    $.ajax({
      type: "POST",
      url: ajaxurl,
      data: {
        "action": 'get_select_post',
        "cat": cat,
      },
      dataType: "text",
      success: function(data) {
        info = JSON.parse(data);
        // マップの更新
        initMap();

        // 記事一覧の更新
        updateArticles(info);

        console.log("click後のinfo:");
        console.log(info);
      },
      error: function(e) {
        console.log(e);
      }
    });


  }); // on click
});
/* ================================================== *
 *
 *  記事一覧の更新
 *
 * ================================================== */
function updateArticles(array) {
  // 一旦、全部記事を消す
  jQuery('.article-list').html('');

  jQuery.each(array, function(index, val) {
    var html =  '<div  class="col-4">'
                + '<div class="card">'
                + '<img class="card-img-top" src="http://localhost/00/portfolio/wp-content/uploads/2022/02/sample.jpg" alt="Card image">'
                + '<div class="card-body">'
                + '<h4 class="card-title">' + val.name + '</h4>'
                + '<div class="card-text">'
                + '<p class="address">' + val.address + '</p>'
                + '<p class="phone">' + val.phone + '</p>'
                + '<p class="email">' + val.email + '</p>'
                + '</div>'
                + '<a href="' + val.website + '" class="btn btn-primary website" target="_blank" rel="noopener noreferrer">See Detail</a>'
                + '</div>'
                + '</div><!-- /card -->'
                + '</div><!-- /col-4 -->';
    // 記事追加
    jQuery('.article-list').append(html);
  });
}

/* ================================================== *
 *
 *   Google Map
 *
 * ================================================== */
function initMap() {
  const map = new google.maps.Map(document.getElementById('gmap'));// goggle map
  const geocoder = new google.maps.Geocoder(); // convert addresses into coordinates(座標)
  let locations = []; // latitude / longitude
  let markers = []; //  markers on the map
  let infoWindows = []; // for a popup

  geo(aftergeo);

  function geo(callback){
    var len = info.length;
    for (var i = 0; i < info.length; i++) {
      (function (i) {
        geocoder.geocode({'address': info[i].address},
          function(results, status) {
            if (status === google.maps.GeocoderStatus.OK && results[0]) {
              locations[i] = results[0].geometry.location;
              markers[i] = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map
              });
              infoWindows[i] = new google.maps.InfoWindow({
                content: '<h4>' + info[i].name + '</h4>'
              });
              // click event
              setMarkerEvent(i);
            } else {
              alert("Geocode was not successful for the following reason: " + status);
            }
            // when finishing the roop
            if (--len <= 0) {
              callback();
            }
          }
        );
      }) (i);// 変数「i」をfunctionの名前空間で保存
    }
  }

  /**
   * set options for a google map
   */
  function aftergeo() {
    const options = {
        center: locations[0], // set the first location as the center position for now
        zoom: 4 // 1 to 20
    };
    map.setOptions(options);
  }

  /**
   * set a click event that shows a popup
   */
  function setMarkerEvent(i) {
    markers[i].addListener('click', function() {
      infoWindows[i].open(map, markers[i]);
    });
  }
};
