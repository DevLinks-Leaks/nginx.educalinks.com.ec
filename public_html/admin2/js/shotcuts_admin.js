shortcut.add("Shift+M", function() {
	$('#modal_quick_access').modal("show");
},{'disable_in_input':true});
/*Alumnos*/
shortcut.add("Alt+A", function() {
	$('#acc_alumnos').trigger('click');
});
shortcut.add("Alt+I", function() {
	if( $('#ul_alumnos').hasClass('menu-open') ){
		$('#acc_alum_insc')[0].click();
	}
},{'disable_in_input':true});
shortcut.add("Alt+L", function() {
	if( $('#ul_alumnos').hasClass('menu-open') ){
		$('#acc_alum_alum')[0].click();
	}
});
shortcut.add("Alt+P", function() {
	if($('#ul_alumnos').hasClass('menu-open') ){
		$('#acc_alum_repr')[0].click();
	}
});
shortcut.add("Alt+Q", function() {
	if( $('#ul_alumnos').hasClass('menu-open') ){
		$('#acc_alum_bloq')[0].click();
	}
});
shortcut.add("Alt+B", function() {
	if( $('#ul_alumnos').hasClass('menu-open') ){
		$('#acc_alum_black')[0].click();
	}
});
/*Cursos*/
shortcut.add("Alt+C", function() {
	$('#acc_cursos').trigger('click');
});
shortcut.add("Alt+P", function() {
	if( $('#ul_cursos').hasClass('menu-open') ){
		$('#acc_cursos_para')[0].click();
	}
});
shortcut.add("Alt+N", function() {
	if( $('#ul_cursos').hasClass('menu-open') ){
		$('#acc_cursos_perm')[0].click();
	}
});
/*Administracion*/
shortcut.add("Alt+D", function() {
	$('#acc_admin').trigger('click');
});
shortcut.add("Alt+P", function() {
	if( $('#ul_admin').hasClass('menu-open') ){
		$('#acc_admin_peri')[0].click();
	}
});
shortcut.add("Alt+S", function() {
	if( $('#ul_admin').hasClass('menu-open') ){
		$('#acc_admin_para_sist')[0].click();
	}
});
/*Reportes*/
shortcut.add("Alt+R", function() {
	$('#acc_repo').trigger('click');
});
shortcut.add("Alt+G", function() {
	if($('#ul_repo').hasClass('menu-open') ){
		$('#acc_repo_gene')[0].click();
	}
});
shortcut.add("Alt+S", function() {
	if($('#ul_repo').hasClass('menu-open') ){
		$('#acc_repo_acta')[0].click();
	}
});
/*Mensajes*/
shortcut.add("Alt+M", function() {
	$('#acc_mens')[0].click();
});