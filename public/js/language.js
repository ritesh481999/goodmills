
//var url = '{{ url("admin/lang/change") }}';
$(document).on('change','.changeLang',function(){
window.location.href = base_url + "/admin/lang/change" + "/" + "?country_id="+ $(this).val();
});