$(function() {
  $(".js-tips").hide();
  $(".js-submit").click(function() {
    let s = $("#inpSearch").val();
    let token = $("meta[name=csrfToken]").attr("content");
    $(".js-tips").show();
    fnAjax(s, token, function(rlt) {
      $(".js-results table").html(rlt);
      $(".js-tips").hide();
    });
    // console.log(s);
    return false;
  });
  function fnAjax(word, token, fun = () => {}) {
    let objRlt;
    $.getJSON(ajaxurl + `tagsPlus&s=${word}&csrfToken=${token}`, function(
      data
    ) {
      if (data && !data.err.code) {
        objRlt = data.data;
        // console.log(objRlt);
        fun(objRlt);
      }
    });
  }
});
