/* USED JQUERY */
/*
$.when($.ready).then(function() {
    $('#revalidate').on('click', function(e) {
        e.preventDefault();
        
        $.ajax({
            'url' => '//' + location.hostname + $('#form_cache_reval').attr('action'),
            'data' => {'cid' : $('#cache_id').val()},
            'type' => 'POST',
            'dataType' => 'json',
            'success' => function(data) {
                if (data.status == 'ok') {
                    location.reload();
                }
            },
        });
    });
});
*/

window.requestOb = null;

window.onload = function () {
    document.getElementById("revalidate").addEventListener('click', function(e) {
        e.preventDefault();
        window.requestOb = new XMLHttpRequest(); 
        window.requestOb.onreadystatechange = function () {
            if (window.requestOb.readyState == 4) {
                if (window.requestOb.status == 200 && JSON.parse(window.requestOb.responseText)['status'] == 'ok') {
                    location.reload();
                }
            }
        }
        window.requestOb.open("POST", document.getElementById("revalidate").parentNode.attributes.action.value, true);
        window.requestOb.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        window.requestOb.send("cid=" + document.getElementById('cache_id').value);
    }); 
}