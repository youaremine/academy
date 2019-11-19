/**
 * Created by James on 2017-04-23.
 */

$(function() {
    $.getJSON('../api/post.php?q=getAllList&postType='+postType, function(data) {
        var _html = template('tpl_post_list', data);
        $('#post_list_group').html(_html);
    });
});