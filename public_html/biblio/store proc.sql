

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 07-09-2015
-- Description:	Listado Categorías
-- =============================================
ALTER PROCEDURE [dbo].[lib_cate_view] 
	
AS
BEGIN
	select
		cate_codi,
		cate_deta
	from
		Lib_Categorias 
	where 
		cate_estado = 'A'
	order by  cate_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Añadir Categorias
-- =============================================
CREATE PROCEDURE [dbo].[lib_cate_add]
	@cate_deta varchar(200)
AS
BEGIN

	set nocount on
	insert into Lib_Categorias 
	values (@cate_deta,'A',null);
	set nocount off

	select @@IDENTITY
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Editar Categorias
-- =============================================
CREATE PROCEDURE [dbo].[lib_cate_edit]
	@cate_codi int,
	@cate_deta varchar(200)
AS
BEGIN

	update Lib_Categorias 
	set cate_deta=@cate_deta 
	where cate_codi=@cate_codi

END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Eliminar Categorias
-- =============================================
CREATE PROCEDURE [dbo].[lib_cate_del]
	@cate_codi int
AS
BEGIN

	update Lib_Categorias 
	set cate_estado='I' 
	where cate_codi=@cate_codi

END

--Descriptores-----------------------------------------------------

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks
-- Create date: 07-09-2015
-- Description:	Listado descriptores
-- del estudiante
-- =============================================
CREATE PROCEDURE [dbo].[lib_desc_view] 
	
AS
BEGIN
	select
		desc_codi,
		desc_deta
	from
		Lib_Descriptores
	where 
		desc_estado = 'A'
	order by  desc_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Añadir Descriptores
-- =============================================
CREATE PROCEDURE [dbo].[lib_desc_add]
	@desc_deta varchar(200)
AS
BEGIN

	set nocount on
	insert into Lib_Descriptores 
	values (@desc_deta,'A',null);
	set nocount off

	select @@IDENTITY
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Editar Descriptores
-- =============================================
CREATE PROCEDURE [dbo].[lib_desc_edit]
	@desc_codi int,
	@desc_deta varchar(200)
AS
BEGIN

	update Lib_Descriptores 
	set desc_deta=@desc_deta 
	where desc_codi=@desc_codi

END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Eliminar Descriptores
-- =============================================
CREATE PROCEDURE [dbo].[lib_desc_del]
	@desc_codi int
AS
BEGIN

	update Lib_Descriptores 
	set desc_estado='I' 
	where desc_codi=@desc_codi

END


--Tipos------------------------------------------------


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks
-- Create date: 07-09-2015
-- Description:	Listado Tipos Documentos
--
-- =============================================
CREATE PROCEDURE [dbo].[lib_tipo_view] 
	
AS
BEGIN
	select
		tipo_codi,
		tipo_deta,
		tipo_default
	from
		Lib_Tipos
	where 
		tipo_estado = 'A'
	order by  tipo_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Añadir Tipos
-- =============================================
CREATE PROCEDURE [dbo].[lib_tipo_add]
	@tipo_deta varchar(200)
AS
BEGIN

	set nocount on
	insert into Lib_Tipos 
	values (@tipo_deta,'A',0,null);
	set nocount off

	select @@IDENTITY
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Editar Tipos
-- =============================================
CREATE PROCEDURE [dbo].[lib_tipo_edit]
	@tipo_codi int,
	@tipo_deta varchar(200)
AS
BEGIN

	update Lib_Tipos 
	set tipo_deta=@tipo_deta 
	where tipo_codi=@tipo_codi

END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Eliminar Tipos
-- =============================================
CREATE PROCEDURE [dbo].[lib_tipo_del]
	@tipo_codi int
AS
BEGIN

	update Lib_Tipos 
	set tipo_estado='I' 
	where tipo_codi=@tipo_codi

END

--Autores-------------------------------------------------------


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchón
-- Create date: 07-09-2015
-- Description:	Listado Autores
--
-- =============================================
ALTER PROCEDURE [dbo].[lib_auto_view] 
	
AS
BEGIN
	select
		auto_codi,
		auto_nomb,
		auto_apel
	from
		Lib_Autores
	where 
		auto_estado = 'A'
	order by  auto_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Añadir Autores
-- =============================================
CREATE PROCEDURE [dbo].[lib_auto_add]
	@auto_nomb varchar(200),
	@auto_apel varchar(200)
AS
BEGIN

	set nocount on
	insert into Lib_Autores 
	values (@auto_nomb,@auto_apel,'A',null);
	set nocount off

	select @@IDENTITY
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Editar Autores
-- =============================================
CREATE PROCEDURE [dbo].[lib_auto_edit]
	@auto_codi int,
	@auto_nomb varchar(200),
	@auto_apel varchar(200)
AS
BEGIN

	update Lib_Autores 
	set auto_nomb=@auto_nomb, auto_apel=@auto_apel 
	where auto_codi=@auto_codi

END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Eliminar Autores
-- =============================================
CREATE PROCEDURE [dbo].[lib_auto_del]
	@auto_codi int
AS
BEGIN

	update Lib_Autores 
	set auto_estado='I' 
	where auto_codi=@auto_codi

END

--Procedencia-------------------------------------------------------



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks
-- Create date: 07-09-2015
-- Description:	Listado Procedencias
--
-- =============================================
CREATE PROCEDURE [dbo].[lib_proc_view] 
	
AS
BEGIN
	select
		proc_codi,
		proc_deta
	from
		Lib_Procedencias
	where 
		proc_estado = 'A'
	order by  proc_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Añadir Procedencias
-- =============================================
CREATE PROCEDURE [dbo].[lib_proc_add]
	@proc_deta varchar(200)
AS
BEGIN

	set nocount on
	insert into Lib_Procedencias 
	values (@proc_deta,'A',null);
	set nocount off

	select @@IDENTITY
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Editar Procedencias
-- =============================================
CREATE PROCEDURE [dbo].[lib_proc_edit]
	@proc_codi int,
	@proc_deta varchar(200)
AS
BEGIN

	update Lib_Procedencias 
	set proc_deta=@proc_deta 
	where proc_codi=@proc_codi

END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Eliminar Procedencia
-- =============================================
CREATE PROCEDURE [dbo].[lib_proc_del]
	@proc_codi int
AS
BEGIN

	update Lib_Procedencias 
	set proc_estado='I' 
	where proc_codi=@proc_codi

END


--Colecciones-------------------------------------------------------



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 07-09-2015
-- Description:	Listado Colecciones
--
-- =============================================
ALTER PROCEDURE [dbo].[lib_cole_view] 
	
AS
BEGIN
	select
		cole_codi,
		cole_deta
	from
		Lib_Colecciones
	where 
		cole_estado = 'A'
	order by  cole_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Añadir Colecciones
-- =============================================
CREATE PROCEDURE [dbo].[lib_cole_add]
	@cole_deta varchar(200)
AS
BEGIN

	set nocount on
	insert into Lib_Colecciones 
	values (@cole_deta,'A',null);
	set nocount off

	select @@IDENTITY
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Editar Colecciones
-- =============================================
CREATE PROCEDURE [dbo].[lib_cole_edit]
	@cole_codi int,
	@cole_deta varchar(200)
AS
BEGIN

	update Lib_Colecciones 
	set cole_deta=@cole_deta 
	where cole_codi=@cole_codi

END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Eliminar Colecciones
-- =============================================
CREATE PROCEDURE [dbo].[lib_cole_del]
	@cole_codi int
AS
BEGIN

	update Lib_Colecciones 
	set cole_estado='I' 
	where cole_codi=@cole_codi

END

--EDITORIALES-------------------------------------------------------



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 21-11-2016
-- Description:	Listado Editoriales
--
-- =============================================
ALTER PROCEDURE [dbo].[lib_edit_view] 
	
AS
BEGIN
	select
		edit_codi,
		edit_deta
	from
		Lib_Editoriales
	where 
		edit_estado = 'A'
	order by  edit_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 21-11-2016
-- Description:	Añadir Editoriales
-- =============================================
CREATE PROCEDURE [dbo].[lib_edit_add]
	@edit_deta varchar(200)
AS
BEGIN

	set nocount on
	insert into Lib_Editoriales 
	values (@edit_deta,'A',null);
	set nocount off

	select @@IDENTITY
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 21-11-2016
-- Description:	Editar Editoriales
-- =============================================
CREATE PROCEDURE [dbo].[lib_edit_edit]
	@edit_codi int,
	@edit_deta varchar(200)
AS
BEGIN

	update Lib_Editoriales 
	set edit_deta=@edit_deta 
	where edit_codi=@edit_codi

END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Eliminar Editoriales
-- =============================================
ALTER PROCEDURE [dbo].[lib_edit_del] 
	@edit_codi int
AS
BEGIN

	update Lib_Editoriales 
	set edit_estado='I' 
	where edit_codi=@edit_codi

END

--RECURSOS---------------------------------------------------------

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 25-11-2016
-- Description:	Listado Recursos
--
-- =============================================
CREATE PROCEDURE [dbo].[lib_recu_view] 
	
AS
BEGIN
	select
		recu_codi,
		recu_titu,
		recu_isbn,
		recu_issn,
		recu_tipo_codi,
		Lib_Tipos.tipo_deta,
		edit_deta,
		cole_deta,
		recu_fech_regi,
		recu_fech_publ,
		recu_vide_dura,
		recu_vide_resu
	from
		Lib_Recursos
		left join Lib_Tipos
		on Lib_Tipos.tipo_codi=Lib_Recursos.recu_tipo_codi
		left join Lib_Editoriales
		on Lib_Editoriales.edit_codi=Lib_Recursos.recu_edit_codi
		left join Lib_Colecciones
		on Lib_Colecciones.cole_codi=Lib_Recursos.recu_cole_codi
	where 
		recu_estado = 'A'
	order by  recu_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 25-11-2016
-- Description:	Listado Autores de Recurso
--
-- =============================================
CREATE PROCEDURE [dbo].[lib_recu_auto_view] 
	@recu_codi bigint
AS
BEGIN
	select
		recu_codi,
		a.auto_codi,
		a.auto_nomb,
		a.auto_apel,
		auto_tipo,
		( case auto_tipo
				when 'A' then 'Autor' --autor
				when 'AC' then 'Actor' --actor
				when 'D' then 'Director' --director
			end
		) as auto_tipo_deta
	from
		Lib_Recursos_Autores
		left join Lib_Autores a
		on a.auto_codi = Lib_Recursos_Autores.auto_codi
	where 
		recu_codi = @recu_codi

	order by auto_tipo desc
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 25-11-2016
-- Description:	Listado Categorías por Recurso
--
-- =============================================
CREATE PROCEDURE [dbo].[lib_recu_cate_view]
	@recu_codi bigint
AS
BEGIN
	select
		recu_codi,
		Lib_Recursos_Categorias.cate_codi,
		c.cate_deta
	from
		Lib_Recursos_Categorias
		left join Lib_categorias c
		on c.cate_codi=Lib_Recursos_Categorias.cate_codi
		
	where 
		recu_codi = @recu_codi
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 25-11-2016
-- Description:	Listado Descriptores por Recurso
--
-- =============================================
CREATE PROCEDURE [dbo].[lib_recu_desc_view]
	@recu_codi bigint
AS
BEGIN
	select
		recu_codi,
		d.desc_codi,
		d.desc_deta
	from
		Lib_Recursos_Descriptores
		left join Lib_Descriptores d
		on d.desc_codi=Lib_Recursos_Descriptores.desc_codi
		
	where 
		recu_codi = @recu_codi
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 25-11-2016
-- Description:	Información de Recurso
--
-- =============================================
CREATE PROCEDURE [dbo].[lib_recu_info] 
	 @recu_codi bigint
AS
BEGIN
	select
		recu_codi,
		recu_titu,
		recu_isbn,
		recu_issn,
		recu_fech_publ,
		recu_vide_dura,
		recu_vide_resu,
		recu_tipo_codi,
		recu_edit_codi,
		recu_cole_codi,
		e.edit_deta,
		c.cole_deta
	from
		Lib_Recursos r
		left join Lib_Editoriales e
		on r.recu_edit_codi=e.edit_codi
		left join Lib_Colecciones c
		on r.recu_cole_codi=c.cole_codi
	where
		recu_codi=@recu_codi
END

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS, Jimmy Banchon	
-- Create date: 2016 NOV 24	
-- Description:	Crea un Recurso
-- =============================================
CREATE Procedure [dbo].[lib_recu_add] 
	 @recu_titu varchar(200)
	,@recu_isbn varchar(50)
	,@recu_issn varchar(50)
	,@recu_fech_publ date
	,@recu_vide_dura time
	,@recu_vide_resu varchar(500)
	,@recu_tipo_codi int
	,@recu_edit_codi int
	,@recu_cole_codi int
	,@xml_recu_auto text --se recibe como un text
	,@xml_recu_cate text
	,@xml_recu_desc text
as
begin
begin transaction trans_recurso_add --USAR TRANSACCION PARA ESTO DE XML
begin try
	
	--/*Variables*/
	declare  @recu_codi bigint
			,@auto_codi	int
			,@auto_tipo	VARCHAR(2)
			,@cate_codi int
			,@desc_codi	int
	set nocount on

	insert into Lib_Recursos (recu_titu,recu_isbn,recu_issn,recu_fech_publ,recu_fech_regi,recu_vide_dura,
								recu_vide_resu,recu_tipo_codi,recu_edit_codi,recu_cole_codi)
			values (@recu_titu,@recu_isbn,@recu_issn,@recu_fech_publ,getdate(),@recu_vide_dura,
								@recu_vide_resu,@recu_tipo_codi,@recu_edit_codi,@recu_cole_codi)
	
	set @recu_codi=@@identity
	
	--/*Extrayendo autores*/
	declare @autoDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @autoDoc output,@xml_recu_auto --transforma en alg para leerlo

	insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
	select --esto trae todo lo que encuentre
		@recu_codi
		,auto_codi
		,auto_tipo	
	from 
		openxml(@autoDoc,N'root/recu_auto')  --leo las notas
		with 
			(auto_codi int '@auto_codi',
				auto_tipo VARCHAR(2) '@auto_tipo');

	exec sp_xml_removedocument @autoDoc
	--/*FINAL EXTRACCION AUTORES*/

	--/*Extrayendo CATEGORIAS*/
	declare @cateDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @cateDoc output,@xml_recu_cate --transforma en alg para leerlo

	insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
	select 
		@recu_codi,cate_codi	
	from 
		openxml(@cateDoc,N'root/recu_cate') 
		with 
			(cate_codi int '@cate_codi');

	exec sp_xml_removedocument @cateDoc
	--/*FINAL EXTRACCION CATEGORIAS*/

	--/*Extrayendo DESCRIPTORES*/
	declare @descDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @descDoc output,@xml_recu_desc --transforma en alg para leerlo
	
	insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
	select 
		@recu_codi,desc_codi	
	from 
		openxml(@descDoc,N'root/recu_desc')  
		with 
			(desc_codi int '@desc_codi');

	exec sp_xml_removedocument @descDoc
	--/*FINAL EXTRACCION DESCRIPTORES*/

	set nocount off

	select @recu_codi

	commit transaction trans_recurso_add
end try
begin catch
	rollback transaction trans_recurso_add
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END



SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS, Jimmy Banchon	
-- Create date: 2016 NOV 24	
-- Description: Editar un Recurso
-- =============================================
create procedure [dbo].[lib_recu_edit] 
	 @recu_codi bigint
	,@recu_titu varchar(200)
	,@recu_isbn varchar(50)
	,@recu_issn varchar(50)
	,@recu_fech_publ date
	,@recu_vide_dura time
	,@recu_vide_resu varchar(500)
	,@recu_tipo_codi int
	,@recu_edit_codi int
	,@recu_cole_codi int
	,@xml_recu_auto text --se recibe como un text
	,@xml_recu_cate text
	,@xml_recu_desc text
as
begin
begin transaction trans_recurso_edit --USAR TRANSACCION PARA ESTO DE XML
begin try
	
	--/*Variables*/
	declare  
			 @auto_codi	int
			,@auto_tipo	VARCHAR(2)
			,@cate_codi int
			,@desc_codi	int
	set nocount on

	UPDATE Lib_Recursos set recu_titu=@recu_titu,recu_isbn=@recu_isbn,recu_issn=@recu_issn,recu_fech_publ=@recu_fech_publ
							,recu_vide_dura=@recu_vide_dura,recu_vide_resu=@recu_vide_resu,recu_tipo_codi=@recu_tipo_codi
							,recu_edit_codi=@recu_edit_codi,recu_cole_codi=@recu_cole_codi
			where recu_codi=@recu_codi
	
	---------------------------------------------------------------------------------------------
	--/*Extrayendo autores*/
	declare @autoDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @autoDoc output,@xml_recu_auto

	delete from Lib_Recursos_Autores where recu_codi=@recu_codi

	DECLARE cur_auto CURSOR FOR
		select --esto trae todo lo que encuentre
			 auto_codi
			,auto_tipo	
		from 
			openxml(@autoDoc,N'root/recu_auto')  --leo las notas
			with 
				(auto_codi int '@auto_codi',
					auto_tipo VARCHAR(2) '@auto_tipo');
	OPEN cur_auto
	FETCH NEXT FROM cur_auto INTO @auto_codi,@auto_tipo
	WHILE @@FETCH_STATUS = 0  
	BEGIN  
		insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
		values (@recu_codi,@auto_codi,@auto_tipo)	

		FETCH NEXT FROM cur_auto INTO @auto_codi,@auto_tipo
	END
	CLOSE cur_auto
	DEALLOCATE cur_auto
	exec sp_xml_removedocument @autoDoc
	--/*FINAL EXTRACCION AUTORES*/
	-------------------------------------------------------------------------------------------
	--/*Extrayendo CATEGORIAS*/
	declare @cateDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @cateDoc output,@xml_recu_cate

	delete from Lib_Recursos_Categorias where recu_codi=@recu_codi

	DECLARE cur_cate CURSOR FOR
		select 
			cate_codi	
		from 
			openxml(@cateDoc,N'root/recu_cate') 
			with 
				(cate_codi int '@cate_codi');
	OPEN cur_cate
	FETCH NEXT FROM cur_cate INTO @cate_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN  
		insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
			values (@recu_codi,@cate_codi)

		FETCH NEXT FROM cur_cate INTO @cate_codi
	END
	CLOSE cur_cate
	DEALLOCATE cur_cate
	exec sp_xml_removedocument @cateDoc
	--/*FINAL EXTRACCION CATEGORIAS*/
	----------------------------------------------------------------------------------------------
	--/*Extrayendo DESCRIPTORES*/
	declare @descDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @descDoc output,@xml_recu_desc
	
	delete from Lib_Recursos_Descriptores where recu_codi=@recu_codi

	DECLARE cur_desc CURSOR FOR
		select 
			desc_codi	
		from 
			openxml(@descDoc,N'root/recu_desc')  
			with 
				(desc_codi int '@desc_codi');
	OPEN cur_desc
	FETCH NEXT FROM cur_desc INTO @desc_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN  
		insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
			values (@recu_codi,@desc_codi)

		FETCH NEXT FROM cur_desc INTO @desc_codi
	END
	CLOSE cur_desc
	DEALLOCATE cur_desc
	exec sp_xml_removedocument @descDoc
	--/*FINAL EXTRACCION DESCRIPTORES*/

	set nocount off

	select @recu_codi

	commit transaction trans_recurso_edit
end try
begin catch
	rollback transaction trans_recurso_edit
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 17-11-2016
-- Description:	Eliminar Recursos
-- =============================================
CREATE PROCEDURE [dbo].[lib_recu_del]
	@recu_codi int
AS
BEGIN

	update Lib_Recursos 
	set recu_estado='I' 
	where recu_codi=@recu_codi

END


--ITEM-------------------------------------------------------------


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 30-11-2016
-- Description:	Listado Items por Recurso
-- =============================================
CREATE PROCEDURE [dbo].[lib_item_view] 
	@recu_codi bigint
AS
BEGIN
	select
		item_codi,
		recu_codi,
		item_edic,
		item_fech_ing,
		item_prec,
		item_proc_codi,
		Lib_Procedencias.proc_deta,
		item_estado
	from
		Lib_Recursos_Items
		left join Lib_Procedencias
		on Lib_Procedencias.proc_codi=Lib_Recursos_Items.item_proc_codi
	where 
		recu_codi=@recu_codi and item_estado in ('A','P') 
	order by  item_codi  ASC
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 25-11-2016
-- Description:	Listado todos los items
--
-- =============================================
CREATE PROCEDURE [dbo].[lib_recu_item_view_all] 
	
AS
BEGIN
	select
		Lib_Recursos.recu_codi,
		recu_titu,
		recu_isbn,
		recu_issn,
		recu_tipo_codi,
		recu_estado,
		Lib_Tipos.tipo_deta,
		ri.item_codi,
		ri.item_edic,
		ri.item_fech_ing,
		ri.item_prec,
		ri.item_proc_codi,
		Lib_Procedencias.proc_deta,
		ri.item_estado
	from
		Lib_Recursos
		left join Lib_Tipos
		on Lib_Tipos.tipo_codi=Lib_Recursos.recu_tipo_codi
		left join Lib_Recursos_Items ri
		on ri.recu_codi = Lib_Recursos.recu_codi and ri.item_estado in ('A','P')
		left join Lib_Procedencias
		on Lib_Procedencias.proc_codi=ri.item_proc_codi
	where 
		recu_estado in ('A')
	order by  recu_codi  ASC
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 30-11-2016
-- Description:	Información Item
-- =============================================
CREATE PROCEDURE [dbo].[lib_item_info] 
	@item_codi bigint
AS
BEGIN
	select
		item_codi,
		recu_codi,
		item_edic,
		item_fech_ing,
		item_prec,
		item_proc_codi,
		Lib_Procedencias.proc_deta
	from
		Lib_Recursos_Items
		left join Lib_Procedencias
		on Lib_Procedencias.proc_codi=Lib_Recursos_Items.item_proc_codi
	where 
		item_codi=@item_codi 

END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 30-11-2016
-- Description:	Añadir Items al recurso
-- =============================================
CREATE PROCEDURE [dbo].[lib_item_add]
	 @recu_codi bigint
	,@item_edic varchar(200)
	,@item_fech_ing date
	,@item_prec numeric(18,2)
	,@item_proc_codi int
	,@item_cant int

AS
BEGIN
	--declare  @cant_flag	int =0
	
	--while @cant_flag < @item_cant
	--begin
	--	insert into Lib_Recursos_Items 
	--	values (@recu_codi,@item_edic,@item_fech_ing,@item_prec,@item_proc_codi,'A');
	--	set @cant_flag = @cant_flag + 1
	--end
	insert into Lib_Recursos_Items 
	select @recu_codi,@item_edic,@item_fech_ing,@item_prec,@item_proc_codi,'A'
		from master..spt_values
		where type = 'P' and number between 1 and @item_cant order by number
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 30-11-2016
-- Description:	Editar Items
-- =============================================
CREATE PROCEDURE [dbo].[lib_item_edit]
	 @item_codi int
	,@item_edic varchar(200)
	,@item_fech_ing date
	,@item_prec numeric(18,2)
	,@item_proc_codi int
AS
BEGIN

	update Lib_Recursos_Items 
	set  item_edic=@item_edic
		,item_fech_ing=@item_fech_ing
		,item_prec=@item_prec
		,item_proc_codi=@item_proc_codi 

	where item_codi=@item_codi

END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 30-11-2016
-- Description:	Eliminar Items
-- =============================================
CREATE PROCEDURE [dbo].[lib_item_del]
	@item_codi int
AS
BEGIN

	update Lib_Recursos_Items 
	set item_estado='I' 
	where item_codi=@item_codi

END

--PRESTAMOS-----------------------------------------------------------


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS, Jimmy Banchón	
-- Create date: 2016 DIC 02
-- Description: Listado de usuarios para prestamo de libros
-- =============================================
CREATE PROCEDURE  [dbo].[lib_prest_usua_view]
	@usua_tipo_codi int
AS
BEGIN
	SELECT * FROM (
	SELECT		alum_codi AS usua_codi
				,alum_nomb AS usua_nomb
				,alum_apel AS usua_apel
				,1 AS usua_tipo_codi
	FROM         Alumnos where alum_estado ='A'
	UNION
	SELECT		repr_codi AS usua_codi
				,repr_nomb AS usua_nomb
				,repr_apel AS usua_apel
				,2 AS usua_tipo_codi
	FROM         Representantes where repr_estado ='A'
	UNION
	SELECT		prof_codi AS usua_codi
				,prof_nomb AS usua_nomb
				,prof_apel AS usua_apel
				,3 AS usua_tipo_codi
	FROM         Profesores 
	UNION
	SELECT		usua_codi AS usua_codi
				,usua_nomb AS usua_nomb
				,usua_apel AS usua_apel
				,4 AS usua_tipo_codi
	FROM         Usuarios where usua_estado = 'A'
	) lista
	where usua_tipo_codi=@usua_tipo_codi
	
	order by usua_apel, usua_nomb asc

END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 30-11-2016
-- Description:	Listado tipos usuario para prestamos
-- =============================================
CREATE PROCEDURE [dbo].[lib_usua_view]

AS
BEGIN
	select 
		usua_tipo_codi
		,usua_tipo_deta
	from Usuarios_Tipos
	where usua_tipo_codi in (1,3)
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 30-11-2016
-- Description:	Listado recursos para prestamos
-- =============================================
CREATE PROCEDURE [dbo].[lib_prest_recu_view]
	@recu_tipo_codi int
AS
BEGIN
	select 
		recu_codi
		,recu_titu
		,recu_isbn
		,recu_issn
		,cole_deta
		,edit_deta
	from Lib_Recursos
	left join Lib_Colecciones
	on Lib_Colecciones.cole_codi=Lib_Recursos.recu_cole_codi
	left join Lib_Editoriales
	on Lib_Editoriales.edit_codi=Lib_Recursos.recu_edit_codi
	where recu_tipo_codi = @recu_tipo_codi
		and recu_estado = 'A'
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 06-12-2016
-- Description:	Añadir prestamo
-- =============================================
ALTER PROCEDURE [dbo].[lib_pres_add]
	 @pres_usua_codi varchar(50)
	,@pres_usua_tipo_codi int
	,@pres_fech_devo datetime
	,@pres_obse varchar(500)
	,@xml_pres_item text
AS
BEGIN
begin transaction trans_prestamo_add 
begin try
	
	--/*Variables*/--
	declare  @item_codi bigint,
			@pres_codi bigint

	set nocount on

	insert into Lib_Prestamos (pres_usua_codi,pres_usua_tipo_codi,pres_fech_regi,pres_fech_devo,pres_obse,pres_estado)
			values (@pres_usua_codi,@pres_usua_tipo_codi,getdate(),@pres_fech_devo,@pres_obse,'A')
	
	set @pres_codi=@@identity
	
	--/*Extrayendo ITEMS*/
	declare @itemDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @itemDoc output,@xml_pres_item 

	insert into Lib_Prestamos_Items (pres_codi,item_codi,pres_item_estado)
	select
		@pres_codi
		,item_codi
		,'A'
	from 
		openxml(@itemDoc,N'root/pres_item') 
		with 
			(item_codi int '@item_codi');

	update Lib_Recursos_Items set item_estado='P' where item_codi in (
	select
		item_codi
	from 
		openxml(@itemDoc,N'root/pres_item') 
		with 
			(item_codi int '@item_codi'))

	exec sp_xml_removedocument @itemDoc
	--/*FINAL EXTRACCION ITEMS*/--

	set nocount off

	select @pres_codi

	commit transaction trans_prestamo_add
end try
begin catch
	rollback transaction trans_prestamo_add
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 06-12-2016
-- Description:	Editar prestamo
-- =============================================
CREATE PROCEDURE [dbo].[lib_pres_edit]
	 @pres_codi bigint
	,@pres_fech_devo datetime
AS
BEGIN

	update Lib_Prestamos 
		set pres_fech_devo=@pres_fech_devo 
	where pres_codi = @pres_codi

END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 06-12-2016
-- Description:	Info prestamo
-- =============================================
CREATE PROCEDURE [dbo].[lib_pres_info]
	 @pres_codi bigint
AS
BEGIN

	select
		pres_usua_codi
		,pres_usua_tipo_codi
		,pres_fech_devo
		,pres_obse
		,pres_estado

	from Lib_Prestamos

	where pres_codi=@pres_codi

END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 06-12-2016
-- Description:	Listado Prestamo
-- =============================================
ALTER PROCEDURE [dbo].[lib_pres_view]

AS
BEGIN

	select
		 pres_codi
		,( case pres_usua_tipo_codi
				when 1 then (select alum_apel+' '+alum_nomb from Alumnos where alum_codi = pres_usua_codi)
				when 2 then (select repr_apel+' '+repr_nomb from Representantes where repr_codi = pres_usua_codi)
				when 3 then (select prof_apel+' '+prof_nomb from Profesores where prof_codi = pres_usua_codi)
				when 4 then (select usua_apel+' '+usua_nomb from Usuarios where usua_codi = pres_usua_codi)
			end
		) as usua_deta
		,u.usua_tipo_deta
		,pres_fech_regi
		,pres_fech_devo
		,pres_obse
		,pres_estado

	from Lib_Prestamos
		left join Usuarios_Tipos u
		on pres_usua_tipo_codi=usua_tipo_codi

	where pres_estado in ('A','D')

	order by  pres_codi  ASC
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 06-12-2016
-- Description:	Listado Prestamo con Detalle
-- =============================================
CREATE PROCEDURE [dbo].[lib_pres_item_view_all]

AS
BEGIN

	select
		 Lib_Prestamos.pres_codi
		,( case pres_usua_tipo_codi
				when 1 then (select alum_apel+' '+alum_nomb from Alumnos where alum_codi = pres_usua_codi)
				when 2 then (select repr_apel+' '+repr_nomb from Representantes where repr_codi = pres_usua_codi)
				when 3 then (select prof_apel+' '+prof_nomb from Profesores where prof_codi = pres_usua_codi)
				when 4 then (select usua_apel+' '+usua_nomb from Usuarios where usua_codi = pres_usua_codi)
			end
		) as usua_deta
		,u.usua_tipo_deta
		,r.recu_titu
		,t.tipo_deta
		,pres_fech_devo
		,p.pres_item_fech_reto
		,p.pres_item_estado

	from Lib_Prestamos
		left join Usuarios_Tipos u
		on pres_usua_tipo_codi=usua_tipo_codi
		left join Lib_Prestamos_Items p
		on p.pres_codi=Lib_Prestamos.pres_codi
		left join Lib_Recursos_Items ri
		on ri.item_codi=p.item_codi
		left join Lib_Recursos r
		on r.recu_codi=ri.recu_codi
		left join Lib_Tipos t
		on t.tipo_codi=r.recu_tipo_codi

	where pres_estado in ('A','D') and pres_item_estado in ('A','D')

	order by  pres_codi  ASC
END

SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 07-12-2016
-- Description:	Información del usuario por tipo
-- =============================================
CREATE PROCEDURE [dbo].[lib_usua_by_tipo_info]
	 @usua_codi varchar(50)
	,@usua_tipo_codi int
AS
BEGIN
	--Alumnos
	if @usua_tipo_codi = 1
	begin
		select 
			 alum_apel as usua_apel
			,alum_nomb as usua_nomb
		from
			Alumnos
		where alum_codi = @usua_codi
	end

	--Representantes
	if @usua_tipo_codi = 2
	begin
		select top 1
			 repr_apel as usua_apel
			,repr_nomb as usua_nomb
		from
			Representantes
		where repr_codi = @usua_codi
	end

	--Docentes
	if @usua_tipo_codi = 3
	begin
		select top 1
			 prof_apel as usua_apel
			,prof_nomb as usua_nomb
		from
			Profesores
		where prof_codi = @usua_codi		
	end

	--Administrativos
	if @usua_tipo_codi = 4
	begin
		select top 1
			 usua_apel as usua_apel
			,usua_nomb as usua_nomb
		from
			Usuarios
		where usua_codi = @usua_codi
	end
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 07-12-2016
-- Description:	Información del usuario por tipo
-- =============================================
CREATE PROCEDURE [dbo].[lib_pres_item_view] 
	 @pres_codi bigint
	
AS
BEGIN
	select
		p.item_codi
		,p.pres_item_codi
		,p.pres_item_estado
		,p.pres_item_fech_reto
		,r.recu_isbn
		,r.recu_issn
		,r.recu_titu
		,r.recu_tipo_codi
		,t.tipo_deta

	from Lib_Prestamos_Items p
	left join Lib_Recursos_Items ri
	on ri.item_codi=p.item_codi
	left join Lib_Recursos r
	on r.recu_codi=ri.recu_codi
	left join Lib_Tipos t
	on t.tipo_codi=r.recu_tipo_codi

	where pres_codi=@pres_codi
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 30-11-2016
-- Description:	Eliminar Prestamos, 
--	retornar a estado original items prestados.
-- =============================================
CREATE PROCEDURE [dbo].[lib_pres_del]
	@pres_codi int
AS
BEGIN
begin transaction trans_pres_del
begin try

	update Lib_Prestamos 
	set pres_estado='I' 
	where pres_codi=@pres_codi

	update Lib_Recursos_Items 
	set item_estado='A' 
	where item_codi= (select item_codi from Lib_Prestamos_Items where pres_codi=@pres_codi and pres_item_estado='A')

	update Lib_Prestamos_Items
	set pres_item_estado='I' 
	where pres_codi=@pres_codi

	commit transaction trans_pres_del
end try
begin catch
	rollback transaction trans_pres_del
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 13-12-2016
-- Description:	Devolución Prestamos
-- =============================================
CREATE PROCEDURE [dbo].[lib_pres_devo] 
	@pres_codi int
AS
BEGIN
begin transaction trans_pres_devo
begin try

	update Lib_Prestamos 
	set pres_estado='D' 
	where pres_codi=@pres_codi

	update Lib_Recursos_Items 
	set item_estado='A' 
	where item_codi in (select item_codi from Lib_Prestamos_Items where pres_codi=@pres_codi and pres_item_estado='A')

	update Lib_Prestamos_Items
	set pres_item_estado='D' , pres_item_fech_reto=getdate() 
	where pres_codi=@pres_codi

	commit transaction trans_pres_devo
end try
begin catch
	rollback transaction trans_pres_devo
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Redlinks, Jimmy Banchon
-- Create date: 13-12-2016
-- Description:	Devolución Prestamos Items
-- =============================================
CREATE PROCEDURE [dbo].[lib_pres_devo_item]
	@pres_item_codi int
AS
BEGIN
begin transaction trans_pres_devo_item
begin try

	Declare  @pres_codi bigint,
			@total_items int,
			@items_prestados int

	update Lib_Recursos_Items 
	set item_estado='A' 
	where item_codi= (select item_codi from Lib_Prestamos_Items where pres_item_codi=@pres_item_codi)

	update Lib_Prestamos_Items
	set pres_item_estado='D' , pres_item_fech_reto=getdate() 
	where pres_item_codi=@pres_item_codi

	select @pres_codi=pres_codi from Lib_Prestamos_Items where pres_item_codi=@pres_item_codi

	select @items_prestados=count(pres_item_codi) from Lib_Prestamos_Items where pres_codi=@pres_codi and pres_item_estado='D'
	select @total_items=count(pres_item_codi) from Lib_Prestamos_Items where pres_codi=@pres_codi

	if @items_prestados >= @total_items
	begin
		update Lib_Prestamos 
		set pres_estado='D' 
		where pres_codi=@pres_codi
	end

	commit transaction trans_pres_devo_item
end try
begin catch
	rollback transaction trans_pres_devo_item
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END


----MIGRACIONES-----------------------------------------------------------------------------



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración autores Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_autores_xls]

@autor_xml text

AS
BEGIN
begin transaction trans_migra_auto
begin try

	--/*Extrayendo autores*/
	declare @autorDoc as int 	--/*Generando tipo XML*/
			,@auto_nomb as varchar(200)
			,@auto_apel as varchar(200)
			,@auto_migr_codi as varchar(200)
	exec sp_xml_preparedocument @autorDoc output,@autor_xml 
	
	IF CURSOR_STATUS('global','migra_auto')>=-1
	BEGIN
	 DEALLOCATE migra_auto
	END

	DECLARE migra_auto CURSOR FOR
		select
			auto_nomb
			,auto_apel
			,auto_migr_codi
		from 
			openxml(@autorDoc,N'root/autor') 
			with 
				(auto_nomb varchar(200) '@auto_nomb',
				 auto_apel varchar(200) '@auto_apel',
				 auto_migr_codi varchar(200) '@auto_migr_codi');
	OPEN migra_auto
	FETCH NEXT FROM migra_auto INTO @auto_nomb,@auto_apel,@auto_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN   
		if (select count(*) from Lib_Autores where auto_migr_codi=@auto_migr_codi and auto_estado='A') = 0
		begin
				insert into Lib_Autores (auto_nomb,auto_apel,auto_estado,auto_migr_codi)
				values ( @auto_nomb,@auto_apel,'A',@auto_migr_codi)
		end

		FETCH NEXT FROM migra_auto INTO @auto_nomb,@auto_apel,@auto_migr_codi
	END
	CLOSE migra_auto
	DEALLOCATE migra_auto

	exec sp_xml_removedocument @autorDoc
	--/*FINAL EXTRACCION ITEMS*/--
	
	commit transaction trans_migra_auto
end try
begin catch
	rollback transaction trans_migra_auto
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración categorias Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_categorias_xls]

@categoria_xml text

AS
BEGIN
begin transaction trans_migra_cate
begin try

	--/*Extrayendo autores*/
	declare @cateDoc as int 	--/*Generando tipo XML*/
			,@cate_deta as varchar(200)
			,@cate_migr_codi as varchar(200)
	exec sp_xml_preparedocument @cateDoc output,@categoria_xml 

	IF CURSOR_STATUS('global','migra_cate')>=-1
	BEGIN
	 DEALLOCATE migra_cate
	END

	DECLARE migra_cate CURSOR FOR
	select
		cate_deta
		,cate_migr_codi
	from 
		openxml(@cateDoc,N'root/cate') 
		with 
			(cate_deta varchar(200) '@cate_deta',
			cate_migr_codi varchar(200) '@cate_migr_codi');

	OPEN migra_cate
	FETCH NEXT FROM migra_cate INTO @cate_deta,@cate_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN   
		if (select count(*) from Lib_Categorias where cate_migr_codi=@cate_migr_codi and cate_estado='A') = 0
		begin
				insert into Lib_Categorias(cate_deta,cate_estado,cate_migr_codi)
				values (@cate_deta,'A',@cate_migr_codi)
		end

		FETCH NEXT FROM migra_cate INTO @cate_deta,@cate_migr_codi
	END
	CLOSE migra_cate
	DEALLOCATE migra_cate

	exec sp_xml_removedocument @cateDoc
	--/*FINAL EXTRACCION ITEMS*/--

	commit transaction trans_migra_cate
end try
begin catch
	rollback transaction trans_migra_cate
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración descriptores Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_descriptores_xls]

@descriptor_xml text

AS
BEGIN
begin transaction trans_migra_desc
begin try

	--/*Extrayendo autores*/
	declare @descDoc as int 	--/*Generando tipo XML*/
			,@desc_deta as varchar(200)
			,@desc_migr_codi as varchar(200)
	exec sp_xml_preparedocument @descDoc output,@descriptor_xml 
	
	IF CURSOR_STATUS('global','migra_desc')>=-1
	BEGIN
	 DEALLOCATE migra_desc
	END

	DECLARE migra_desc CURSOR FOR
		select
			desc_deta
			,desc_migr_codi
		from 
			openxml(@descDoc,N'root/desc') 
			with 
				(desc_deta varchar(200) '@desc_deta',
				desc_migr_codi varchar(200) '@desc_migr_codi');
	OPEN migra_desc
	FETCH NEXT FROM migra_desc INTO @desc_deta,@desc_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN   
		if (select count(*) from Lib_Descriptores where desc_migr_codi=@desc_migr_codi and desc_estado='A') = 0
		begin
				insert into Lib_Descriptores(desc_deta,desc_estado,desc_migr_codi)
				values (@desc_deta,'A',@desc_migr_codi)
		end

		FETCH NEXT FROM migra_desc INTO @desc_deta,@desc_migr_codi
	END
	CLOSE migra_desc
	DEALLOCATE migra_desc

	exec sp_xml_removedocument @descDoc
	--/*FINAL EXTRACCION ITEMS*/--

	commit transaction trans_migra_desc
end try
begin catch
	rollback transaction trans_migra_desc
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración tipos Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_tipos_xls]

@tipos_xml text

AS
BEGIN
begin transaction trans_migra_tipo
begin try

	--/*Extrayendo autores*/
	declare @tipoDoc as int 	--/*Generando tipo XML*/
			,@tipo_deta as varchar(200)
			,@tipo_migr_codi as varchar(200)
	exec sp_xml_preparedocument @tipoDoc output,@tipos_xml 

	IF CURSOR_STATUS('global','migra_tipo')>=-1
	BEGIN
	 DEALLOCATE migra_tipo
	END

	DECLARE migra_tipo CURSOR FOR
	select
		tipo_deta
		,tipo_migr_codi
	from 
		openxml(@tipoDoc,N'root/tipo') 
		with 
			(tipo_deta varchar(200) '@tipo_deta',
			tipo_migr_codi varchar(200) '@tipo_migr_codi');


	OPEN migra_tipo
	FETCH NEXT FROM migra_tipo INTO @tipo_deta,@tipo_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN   
		if (select count(*) from Lib_Tipos where tipo_migr_codi=@tipo_migr_codi and tipo_estado='A') = 0
		begin
			insert into Lib_Tipos(tipo_deta,tipo_estado,tipo_migr_codi)
				values (@tipo_deta,'A',@tipo_migr_codi)
		end

		FETCH NEXT FROM migra_tipo INTO @tipo_deta,@tipo_migr_codi
	END
	CLOSE migra_tipo
	DEALLOCATE migra_tipo

	exec sp_xml_removedocument @tipoDoc
	--/*FINAL EXTRACCION ITEMS*/--

	commit transaction trans_migra_tipo
end try
begin catch
	rollback transaction trans_migra_tipo
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración colecciones Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_coleccion_xls]

@coleccion_xml text

AS
BEGIN
begin transaction trans_migra_cole
begin try

	--/*Extrayendo autores*/
	declare @coleDoc as int 	--/*Generando tipo XML*/
			,@cole_deta as varchar(200)
			,@cole_migr_codi as varchar(200)
	exec sp_xml_preparedocument @coleDoc output,@coleccion_xml 

	IF CURSOR_STATUS('global','migra_cole')>=-1
	BEGIN
	 DEALLOCATE migra_cole
	END

	DECLARE migra_cole CURSOR FOR
	select
		cole_deta
		,cole_migr_codi
	from 
		openxml(@coleDoc,N'root/cole') 
		with 
			(cole_deta varchar(200) '@cole_deta',
			cole_migr_codi varchar(200) '@cole_migr_codi');

	OPEN migra_cole
	FETCH NEXT FROM migra_cole INTO @cole_deta,@cole_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN   
		if (select count(*) from Lib_Colecciones where cole_migr_codi=@cole_migr_codi and cole_estado='A') = 0
		begin
			insert into Lib_Colecciones(cole_deta,cole_estado,cole_migr_codi)
				values (@cole_deta,'A',@cole_migr_codi)
		end

		FETCH NEXT FROM migra_cole INTO @cole_deta,@cole_migr_codi
	END
	CLOSE migra_cole
	DEALLOCATE migra_cole

	exec sp_xml_removedocument @coleDoc
	--/*FINAL EXTRACCION ITEMS*/--

	commit transaction trans_migra_cole
end try
begin catch
	rollback transaction trans_migra_cole
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración colecciones Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_editorial_xls]

@editorial_xml text

AS
BEGIN
begin transaction trans_migra_edit
begin try

	--/*Extrayendo autores*/
	declare @editDoc as int 	--/*Generando tipo XML*/
			,@edit_deta as varchar(200)
			,@edit_migr_codi as varchar(200)
	exec sp_xml_preparedocument @editDoc output,@editorial_xml 

	IF CURSOR_STATUS('global','migra_edit')>=-1
	BEGIN
	 DEALLOCATE migra_edit
	END

	DECLARE migra_edit CURSOR FOR
		select
			edit_deta
			,edit_migr_codi
		from 
			openxml(@editDoc,N'root/proc') 
			with 
				(edit_deta varchar(200) '@edit_deta',
				edit_migr_codi varchar(200) '@edit_migr_codi');
	OPEN migra_edit
	FETCH NEXT FROM migra_edit INTO @edit_deta,@edit_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN   
		if (select count(*) from Lib_Editoriales where edit_migr_codi=@edit_migr_codi and edit_estado='A') = 0
		begin
			insert into Lib_Editoriales(edit_deta,edit_estado,edit_migr_codi)
				values (@edit_deta,'A',@edit_migr_codi)
		end

		FETCH NEXT FROM migra_edit INTO @edit_deta,@edit_migr_codi
	END
	CLOSE migra_edit
	DEALLOCATE migra_edit

	exec sp_xml_removedocument @editDoc
	--/*FINAL EXTRACCION ITEMS*/--

	commit transaction trans_migra_edit
end try
begin catch
	rollback transaction trans_migra_edit
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración procedencia Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_procedencia_xls]

@procedencia_xml text

AS
BEGIN
begin transaction trans_migra_proc
begin try

	--/*Extrayendo autores*/
	declare @procDoc as int 	--/*Generando tipo XML*/
			,@proc_deta as varchar(200)
			,@proc_migr_codi as varchar(200)
	exec sp_xml_preparedocument @procDoc output,@procedencia_xml 

	IF CURSOR_STATUS('global','migra_proc')>=-1
	BEGIN
	 DEALLOCATE migra_proc
	END

	DECLARE migra_proc CURSOR FOR
		select
			proc_deta
			,proc_migr_codi
		from 
			openxml(@procDoc,N'root/proc') 
			with 
				(proc_deta varchar(200) '@proc_deta',
				proc_migr_codi varchar(200) '@proc_migr_codi');
	OPEN migra_proc
	FETCH NEXT FROM migra_proc INTO @proc_deta,@proc_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN   
		if (select count(*) from Lib_Procedencias where proc_migr_codi=@proc_migr_codi and proc_estado='A') = 0
		begin
			insert into Lib_Procedencias (proc_deta,proc_estado,proc_migr_codi)
				values (@proc_deta,'A',@proc_migr_codi)
		end

		FETCH NEXT FROM migra_proc INTO @proc_deta,@proc_migr_codi
	END
	CLOSE migra_proc
	DEALLOCATE migra_proc

	exec sp_xml_removedocument @procDoc
	--/*FINAL EXTRACCION ITEMS*/--

	commit transaction trans_migra_proc
end try
begin catch
	rollback transaction trans_migra_proc
	select error_message(),error_line(),error_state(),error_procedure()
end catch
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración recursos libros Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_recursos_libros_xls]

@recursos_xml text

AS
BEGIN
begin transaction trans_recu_libr
begin try
	
	Declare @recu_migr_codi varchar(200)
			,@recu_titu varchar(200)
			,@recu_isbn varchar(50)
			,@recu_edit_migr_codi varchar(200)
			,@recu_cole_migr_codi varchar(200)
			,@recu_fech_publ date
			,@recu_cate_migr_codi varchar(200)
			,@recu_desc_migr_codi varchar(200)
			,@recu_auto_migr_codi varchar(200)
			,@existe_recu int
			,@recu_edit_codi int
			,@recu_cole_codi int
			,@recu_auto_codi int
			,@recu_cate_codi int
			,@recu_desc_codi int
			,@recu_codi bigint
	set nocount on
	--/*Extrayendo autores*/
	declare @recuDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @recuDoc output,@recursos_xml 

	IF CURSOR_STATUS('global','cur_recu_migr')>=-1
	BEGIN
	 DEALLOCATE cur_recu_migr
	END

	DECLARE cur_recu_migr CURSOR FOR
		select
			recu_migr_codi
			,recu_titu
			,recu_isbn
			,recu_edit_migr_codi
			,recu_cole_migr_codi
			,recu_fech_publ
			,recu_cate_migr_codi
			,recu_desc_migr_codi
			,recu_auto_migr_codi
		from 
			openxml(@recuDoc,N'root/recu') 
			with 
				(recu_migr_codi varchar(200) '@recu_migr_codi'
				,recu_titu varchar(200) '@recu_titu'
				,recu_isbn varchar(50) '@recu_isbn'
				,recu_edit_migr_codi varchar(200) '@recu_edit_migr_codi'
				,recu_cole_migr_codi varchar(200) '@recu_cole_migr_codi'
				,recu_fech_publ date '@recu_fech_publ'
				,recu_cate_migr_codi varchar(200) '@recu_cate_migr_codi'
				,recu_desc_migr_codi varchar(200) '@recu_desc_migr_codi'
				,recu_auto_migr_codi varchar(200) '@recu_auto_migr_codi');

	OPEN cur_recu_migr
	FETCH NEXT FROM cur_recu_migr INTO @recu_migr_codi,@recu_titu,@recu_isbn,@recu_edit_migr_codi,@recu_cole_migr_codi
				,@recu_fech_publ,@recu_cate_migr_codi,@recu_desc_migr_codi,@recu_auto_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN  
		set @recu_codi=null
		set @recu_edit_codi=null
		set @recu_cole_codi=null
		set @recu_auto_codi=null
		set @recu_cate_codi=null
		set @recu_desc_codi=null

		select @recu_codi=recu_codi from Lib_Recursos where recu_migr_codi=@recu_migr_codi and recu_estado='A'
		select @recu_edit_codi=edit_codi from Lib_Editoriales where edit_migr_codi=@recu_edit_migr_codi and edit_estado='A'
		select @recu_cole_codi=cole_codi from Lib_Colecciones where cole_migr_codi=@recu_cole_migr_codi and cole_estado='A'
		select @recu_auto_codi=auto_codi from Lib_Autores where auto_migr_codi=@recu_auto_migr_codi and auto_estado='A'
		select @recu_cate_codi=cate_codi from Lib_Categorias where cate_migr_codi=@recu_cate_migr_codi and cate_estado='A'
		select @recu_desc_codi=desc_codi from Lib_Descriptores where desc_migr_codi=@recu_desc_migr_codi and desc_estado='A'

		if  @recu_codi is null
		begin
			insert into Lib_Recursos (recu_titu,recu_tipo_codi,recu_isbn,recu_fech_publ,recu_fech_regi,
								recu_edit_codi,recu_cole_codi,recu_migr_codi)
			values (@recu_titu,1,@recu_isbn,@recu_fech_publ,getdate(),
								@recu_edit_codi,@recu_cole_codi,@recu_migr_codi)
			select @recu_codi=@@IDENTITY

			if @recu_auto_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_codi,'A')
			end
			if @recu_cate_codi is not null
			begin
				insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
				values (@recu_codi,@recu_cate_codi)
			end
			if @recu_desc_codi is not null
			begin
				insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
				values (@recu_codi,@recu_desc_codi)
			end
		end
		else
		begin
			if @recu_auto_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_codi,'A')
			end
			if @recu_cate_codi is not null
			begin
				insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
				values (@recu_codi,@recu_cate_codi)
			end
			if @recu_desc_codi is not null
			begin
				insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
				values (@recu_codi,@recu_desc_codi)
			end
			
		end
		
		FETCH NEXT FROM cur_recu_migr INTO @recu_migr_codi,@recu_titu,@recu_isbn,@recu_edit_migr_codi,@recu_cole_migr_codi
				,@recu_fech_publ,@recu_cate_migr_codi,@recu_desc_migr_codi,@recu_auto_migr_codi
	END
	CLOSE cur_recu_migr
	DEALLOCATE cur_recu_migr

	
	exec sp_xml_removedocument @recuDoc
	--/*FINAL EXTRACCION ITEMS*/--
	set nocount off
	commit transaction trans_recu_libr
end try
begin catch
	rollback transaction trans_recu_libr
	select error_message() as error,error_line(),error_state(),error_procedure()
end catch
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración recursos revistas Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_recursos_revistas_xls]

@recursos_xml text

AS
BEGIN
begin transaction trans_recu_revi
begin try
	
	Declare @recu_migr_codi varchar(200)
			,@recu_titu varchar(200)
			,@recu_issn varchar(50)
			,@recu_edit_migr_codi varchar(200)
			,@recu_cole_migr_codi varchar(200)
			,@recu_fech_publ date
			,@recu_cate_migr_codi varchar(200)
			,@recu_desc_migr_codi varchar(200)
			,@recu_auto_migr_codi varchar(200)
			,@existe_recu int
			,@recu_edit_codi int
			,@recu_cole_codi int
			,@recu_auto_codi int
			,@recu_cate_codi int
			,@recu_desc_codi int
			,@recu_codi bigint
	set nocount on
	--/*Extrayendo autores*/
	declare @recuDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @recuDoc output,@recursos_xml 

	IF CURSOR_STATUS('global','cur_recu_migr_revi')>=-1
	BEGIN
	 DEALLOCATE cur_recu_migr_revi
	END

	DECLARE cur_recu_migr_revi CURSOR FOR
		select
			recu_migr_codi
			,recu_titu
			,recu_issn
			,recu_edit_migr_codi
			,recu_cole_migr_codi
			,recu_fech_publ
			,recu_cate_migr_codi
			,recu_desc_migr_codi
			,recu_auto_migr_codi
		from 
			openxml(@recuDoc,N'root/recu') 
			with 
				(recu_migr_codi varchar(200) '@recu_migr_codi'
				,recu_titu varchar(200) '@recu_titu'
				,recu_issn varchar(50) '@recu_issn'
				,recu_edit_migr_codi varchar(200) '@recu_edit_migr_codi'
				,recu_cole_migr_codi varchar(200) '@recu_cole_migr_codi'
				,recu_fech_publ date '@recu_fech_publ'
				,recu_cate_migr_codi varchar(200) '@recu_cate_migr_codi'
				,recu_desc_migr_codi varchar(200) '@recu_desc_migr_codi'
				,recu_auto_migr_codi varchar(200) '@recu_auto_migr_codi');

	OPEN cur_recu_migr_revi
	FETCH NEXT FROM cur_recu_migr INTO @recu_migr_codi,@recu_titu,@recu_issn,@recu_edit_migr_codi,@recu_cole_migr_codi
				,@recu_fech_publ,@recu_cate_migr_codi,@recu_desc_migr_codi,@recu_auto_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN  

		set @recu_codi=null
		set @recu_edit_codi=null
		set @recu_cole_codi=null
		set @recu_auto_codi=null
		set @recu_cate_codi=null
		set @recu_desc_codi=null

		select @recu_codi=recu_codi from Lib_Recursos where recu_migr_codi=@recu_migr_codi and recu_estado='A'
		select @recu_edit_codi=edit_codi from Lib_Editoriales where edit_migr_codi=@recu_edit_migr_codi and edit_estado='A'
		select @recu_cole_codi=cole_codi from Lib_Colecciones where cole_migr_codi=@recu_cole_migr_codi and cole_estado='A'
		select @recu_auto_codi=auto_codi from Lib_Autores where auto_migr_codi=@recu_auto_migr_codi and auto_estado='A'
		select @recu_cate_codi=cate_codi from Lib_Categorias where cate_migr_codi=@recu_cate_migr_codi and cate_estado='A'
		select @recu_desc_codi=desc_codi from Lib_Descriptores where desc_migr_codi=@recu_desc_migr_codi and desc_estado='A'

		if  @recu_codi is null
		begin
			insert into Lib_Recursos (recu_titu,recu_tipo_codi,recu_issn,recu_fech_publ,recu_fech_regi,
								recu_edit_codi,recu_cole_codi,recu_migr_codi)
			values (@recu_titu,2,@recu_issn,@recu_fech_publ,getdate(),
								@recu_edit_codi,@recu_cole_codi,@recu_migr_codi)
			select @recu_codi=@@IDENTITY

			if @recu_auto_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_codi,'A')
			end
			if @recu_cate_codi is not null
			begin
				insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
				values (@recu_codi,@recu_cate_codi)
			end
			if @recu_desc_codi is not null
			begin
				insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
				values (@recu_codi,@recu_desc_codi)
			end
		end
		else
		begin
			if @recu_auto_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_codi,'A')
			end
			if @recu_cate_codi is not null
			begin
				insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
				values (@recu_codi,@recu_cate_codi)
			end
			if @recu_desc_codi is not null
			begin
				insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
				values (@recu_codi,@recu_desc_codi)
			end
		end
		
		FETCH NEXT FROM cur_recu_migr_revi INTO @recu_migr_codi,@recu_titu,@recu_issn,@recu_edit_migr_codi,@recu_cole_migr_codi
				,@recu_fech_publ,@recu_cate_migr_codi,@recu_desc_migr_codi,@recu_auto_migr_codi
	END
	CLOSE cur_recu_migr_revi
	DEALLOCATE cur_recu_migr_revi

	
	exec sp_xml_removedocument @recuDoc
	--/*FINAL EXTRACCION ITEMS*/--
	set nocount off
	commit transaction trans_recu_revi
end try
begin catch
	rollback transaction trans_recu_revi
	select error_message() as error,error_line(),error_state(),error_procedure()
end catch
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración recursos videos Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_recursos_videos_xls]

@recursos_xml text

AS
BEGIN
begin transaction trans_recu_vide
begin try
	
	Declare @recu_migr_codi varchar(200)
			,@recu_titu varchar(200)
			,@recu_edit_migr_codi varchar(200)
			,@recu_cole_migr_codi varchar(200)
			,@recu_fech_publ date
			,@recu_cate_migr_codi varchar(200)
			,@recu_desc_migr_codi varchar(200)
			,@recu_dire_migr_codi varchar(200)
			,@recu_acto_migr_codi varchar(200)
			,@recu_vide_dura time
			,@recu_vide_resu varchar(500)
			,@recu_edit_codi int
			,@recu_cole_codi int
			,@recu_auto_d_codi int
			,@recu_auto_ac_codi int
			,@recu_cate_codi int
			,@recu_desc_codi int
			,@recu_codi bigint
	set nocount on
	--/*Extrayendo autores*/
	declare @recuDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @recuDoc output,@recursos_xml 

	IF CURSOR_STATUS('global','cur_recu_migr_vide')>=-1
	BEGIN
	 DEALLOCATE cur_recu_migr_vide
	END

	DECLARE cur_recu_migr_vide CURSOR FOR
		select
			recu_migr_codi
			,recu_titu
			,recu_edit_migr_codi
			,recu_cole_migr_codi
			,recu_fech_publ
			,recu_cate_migr_codi
			,recu_desc_migr_codi
			,recu_dire_migr_codi
			,recu_acto_migr_codi
			,recu_vide_dura
			,recu_vide_resu
		from 
			openxml(@recuDoc,N'root/recu') 
			with 
				(recu_migr_codi varchar(200) '@recu_migr_codi'
				,recu_titu varchar(200) '@recu_titu'
				,recu_edit_migr_codi varchar(200) '@recu_edit_migr_codi'
				,recu_cole_migr_codi varchar(200) '@recu_cole_migr_codi'
				,recu_fech_publ date '@recu_fech_publ'
				,recu_cate_migr_codi varchar(200) '@recu_cate_migr_codi'
				,recu_desc_migr_codi varchar(200) '@recu_desc_migr_codi'
				,recu_dire_migr_codi varchar(200) '@recu_dire_migr_codi'
				,recu_acto_migr_codi varchar(200) '@recu_acto_migr_codi'
				,recu_vide_dura time '@recu_vide_dura'
				,recu_vide_resu varchar(500) '@recu_vide_resu');

	OPEN cur_recu_migr_vide
	FETCH NEXT FROM cur_recu_migr_vide INTO @recu_migr_codi,@recu_titu,@recu_edit_migr_codi,@recu_cole_migr_codi
				,@recu_fech_publ,@recu_cate_migr_codi,@recu_desc_migr_codi,@recu_dire_migr_codi,@recu_acto_migr_codi
				,@recu_vide_dura,@recu_vide_resu
	WHILE @@FETCH_STATUS = 0  
	BEGIN  

		set @recu_codi=null
		set @recu_edit_codi=null
		set @recu_cole_codi=null
		set @recu_auto_d_codi=null
		set @recu_auto_ac_codi=null
		set @recu_cate_codi=null
		set @recu_desc_codi=null

		select @recu_codi=recu_codi from Lib_Recursos where recu_migr_codi=@recu_migr_codi and recu_estado='A'
		select @recu_edit_codi=edit_codi from Lib_Editoriales where edit_migr_codi=@recu_edit_migr_codi and edit_estado='A'
		select @recu_cole_codi=cole_codi from Lib_Colecciones where cole_migr_codi=@recu_cole_migr_codi and cole_estado='A'
		select @recu_auto_d_codi=auto_codi from Lib_Autores where auto_migr_codi=@recu_dire_migr_codi and auto_estado='A'
		select @recu_auto_ac_codi=auto_codi from Lib_Autores where auto_migr_codi=@recu_acto_migr_codi and auto_estado='A'
		select @recu_cate_codi=cate_codi from Lib_Categorias where cate_migr_codi=@recu_cate_migr_codi and cate_estado='A'
		select @recu_desc_codi=desc_codi from Lib_Descriptores where desc_migr_codi=@recu_desc_migr_codi and desc_estado='A'

		if  @recu_codi is null
		begin
			insert into Lib_Recursos (recu_titu,recu_tipo_codi,recu_fech_publ,recu_fech_regi,
								recu_edit_codi,recu_cole_codi,recu_vide_dura,recu_vide_resu,recu_migr_codi)
			values (@recu_titu,3,@recu_fech_publ,getdate(),
								@recu_edit_codi,@recu_cole_codi,@recu_vide_dura,@recu_vide_resu,@recu_migr_codi)
			select @recu_codi=@@IDENTITY
			
			if @recu_auto_d_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_d_codi,'D')
			end
			if @recu_auto_ac_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_ac_codi,'AC')
			end

			if @recu_cate_codi is not null
			begin
				insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
				values (@recu_codi,@recu_cate_codi)
			end

			if @recu_desc_codi is not null
			begin
				insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
				values (@recu_codi,@recu_desc_codi)
			end
		end
		else
		begin
			if @recu_auto_d_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_d_codi,'D')
			end
			if @recu_auto_ac_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_ac_codi,'AC')
			end

			if @recu_cate_codi is not null
			begin
				insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
				values (@recu_codi,@recu_cate_codi)
			end

			if @recu_desc_codi is not null
			begin
				insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
				values (@recu_codi,@recu_desc_codi)
			end
		end
		
		FETCH NEXT FROM cur_recu_migr_vide INTO @recu_migr_codi,@recu_titu,@recu_edit_migr_codi,@recu_cole_migr_codi
				,@recu_fech_publ,@recu_cate_migr_codi,@recu_desc_migr_codi,@recu_dire_migr_codi,@recu_acto_migr_codi
				,@recu_vide_dura,@recu_vide_resu
	END
	CLOSE cur_recu_migr_vide
	DEALLOCATE cur_recu_migr_vide

	
	exec sp_xml_removedocument @recuDoc
	--/*FINAL EXTRACCION ITEMS*/--
	set nocount off
	commit transaction trans_recu_vide
end try
begin catch
	rollback transaction trans_recu_vide
	select error_message() as error,error_line(),error_state(),error_procedure()
end catch
END



SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración recursos otros Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_recursos_otros_xls]

@recursos_xml text

AS
BEGIN
begin transaction trans_recu_otro
begin try
	
	Declare @recu_migr_codi varchar(200)
			,@recu_tipo_migr_codi varchar(200)
			,@recu_titu varchar(200)
			,@recu_edit_migr_codi varchar(200)
			,@recu_cole_migr_codi varchar(200)
			,@recu_fech_publ date
			,@recu_cate_migr_codi varchar(200)
			,@recu_desc_migr_codi varchar(200)
			,@recu_auto_migr_codi varchar(200)
			,@recu_vide_resu varchar(500)
			,@recu_edit_codi int
			,@recu_cole_codi int
			,@recu_auto_codi int
			,@recu_cate_codi int
			,@recu_desc_codi int
			,@recu_codi bigint
			,@recu_tipo_codi int

	set nocount on
	--/*Extrayendo autores*/
	declare @recuDoc as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @recuDoc output,@recursos_xml 

	IF CURSOR_STATUS('global','cur_recu_migr_otro')>=-1
	BEGIN
	 DEALLOCATE cur_recu_migr_otro
	END

	DECLARE cur_recu_migr_otro CURSOR FOR
		select
			recu_migr_codi
			,recu_tipo_migr_codi
			,recu_titu
			,recu_edit_migr_codi
			,recu_cole_migr_codi
			,recu_fech_publ
			,recu_cate_migr_codi
			,recu_desc_migr_codi
			,recu_auto_migr_codi
			,recu_vide_resu
		from 
			openxml(@recuDoc,N'root/recu') 
			with 
				(recu_migr_codi varchar(200) '@recu_migr_codi'
				,recu_tipo_migr_codi varchar(200) '@recu_tipo_migr_codi'
				,recu_titu varchar(200) '@recu_titu'
				,recu_edit_migr_codi varchar(200) '@recu_edit_migr_codi'
				,recu_cole_migr_codi varchar(200) '@recu_cole_migr_codi'
				,recu_fech_publ date '@recu_fech_publ'
				,recu_cate_migr_codi varchar(200) '@recu_cate_migr_codi'
				,recu_desc_migr_codi varchar(200) '@recu_desc_migr_codi'
				,recu_auto_migr_codi varchar(200) '@recu_auto_migr_codi'
				,recu_vide_resu varchar(500) '@recu_vide_resu');

	OPEN cur_recu_migr_otro
	FETCH NEXT FROM cur_recu_migr_otro INTO @recu_migr_codi,@recu_tipo_migr_codi,@recu_titu,@recu_edit_migr_codi,@recu_cole_migr_codi
				,@recu_fech_publ,@recu_cate_migr_codi,@recu_desc_migr_codi,@recu_auto_migr_codi,@recu_vide_resu
	WHILE @@FETCH_STATUS = 0  
	BEGIN  
		set @recu_codi=null
		set @recu_edit_codi=null
		set @recu_cole_codi=null
		set @recu_auto_codi=null
		set @recu_cate_codi=null
		set @recu_desc_codi=null
		
		select @recu_codi=recu_codi from Lib_Recursos where recu_migr_codi=@recu_migr_codi and recu_estado='A'
		select @recu_tipo_codi=tipo_codi from Lib_Tipos where tipo_migr_codi=@recu_tipo_migr_codi and tipo_estado='A'
		select @recu_edit_codi=edit_codi from Lib_Editoriales where edit_migr_codi=@recu_edit_migr_codi and edit_estado='A'
		select @recu_cole_codi=cole_codi from Lib_Colecciones where cole_migr_codi=@recu_cole_migr_codi and cole_estado='A'
		select @recu_auto_codi=auto_codi from Lib_Autores where auto_migr_codi=@recu_auto_migr_codi and auto_estado='A'
		select @recu_cate_codi=cate_codi from Lib_Categorias where cate_migr_codi=@recu_cate_migr_codi and cate_estado='A'
		select @recu_desc_codi=desc_codi from Lib_Descriptores where desc_migr_codi=@recu_desc_migr_codi and desc_estado='A'

		if  @recu_codi is null
		begin
			insert into Lib_Recursos (recu_titu,recu_tipo_codi,recu_fech_publ,recu_fech_regi,
								recu_edit_codi,recu_cole_codi,recu_vide_resu,recu_migr_codi)
			values (@recu_titu,@recu_tipo_codi,@recu_fech_publ,getdate(),
								@recu_edit_codi,@recu_cole_codi,@recu_vide_resu,@recu_migr_codi)
			select @recu_codi=@@IDENTITY

			if @recu_auto_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_codi,'A')
			end
			if @recu_cate_codi is not null
			begin
				insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
				values (@recu_codi,@recu_cate_codi)
			end
			if @recu_desc_codi is not null
			begin
				insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
				values (@recu_codi,@recu_desc_codi)
			end
		end
		else
		begin
			if @recu_auto_codi is not null
			begin
				insert into Lib_Recursos_Autores (recu_codi,auto_codi,auto_tipo)
				values (@recu_codi,@recu_auto_codi,'A')
			end
			if @recu_cate_codi is not null
			begin
				insert into Lib_Recursos_Categorias (recu_codi,cate_codi)
				values (@recu_codi,@recu_cate_codi)
			end
			if @recu_desc_codi is not null
			begin
				insert into Lib_Recursos_Descriptores (recu_codi,desc_codi)
				values (@recu_codi,@recu_desc_codi)
			end
		end
		
		FETCH NEXT FROM cur_recu_migr_otro INTO @recu_migr_codi,@recu_tipo_migr_codi,@recu_titu,@recu_edit_migr_codi,@recu_cole_migr_codi
				,@recu_fech_publ,@recu_cate_migr_codi,@recu_desc_migr_codi,@recu_auto_migr_codi,@recu_vide_resu
	END
	CLOSE cur_recu_migr_otro
	DEALLOCATE cur_recu_migr_otro

	
	exec sp_xml_removedocument @recuDoc
	--/*FINAL EXTRACCION ITEMS*/--
	set nocount off

	commit transaction trans_recu_otro
end try
begin catch
	rollback transaction trans_recu_otro
	select error_message() as error,error_line(),error_state(),error_procedure()
end catch
END


SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		REDLINKS	
-- Create date: 08-04-2015
-- Description: Migración recursos items Biblioteca
-- =============================================
CREATE PROCEDURE  [dbo].[lib_migracion_recursos_items_xls]

@recursos_xml text

AS
BEGIN
begin transaction trans_recu_item
begin try
	
	Declare @recu_migr_codi varchar(200)
			,@item_edic varchar(200)
			,@item_fech_ing date
			,@item_prec numeric(18,2)
			,@item_proc_migr_codi varchar(200)
			,@item_proc_codi int
			,@recu_codi bigint

	set nocount on
	--/*Extrayendo autores*/
	declare @recuItem as int 	--/*Generando tipo XML*/
	exec sp_xml_preparedocument @recuItem output,@recursos_xml 

	IF CURSOR_STATUS('global','cur_recu_migr_item')>=-1
	BEGIN
	 DEALLOCATE cur_recu_migr_item
	END

	DECLARE cur_recu_migr_item CURSOR FOR
		select
			recu_migr_codi
			,item_edic
			,item_fech_ing
			,item_prec
			,item_proc_migr_codi
		from 
			openxml(@recuItem,N'root/recu_item') 
			with 
				(recu_migr_codi varchar(200) '@recu_migr_codi'
				,item_edic varchar(200) '@item_edic'
				,item_fech_ing date '@item_fech_ing'
				,item_prec numeric(18,2) '@item_prec'
				,item_proc_migr_codi varchar(200) '@item_proc_migr_codi');

	OPEN cur_recu_migr_item
	FETCH NEXT FROM cur_recu_migr_item INTO @recu_migr_codi,@item_edic,@item_fech_ing,@item_prec,@item_proc_migr_codi
	WHILE @@FETCH_STATUS = 0  
	BEGIN  
		set @recu_codi=null
		set @item_proc_codi=null
		
		select @recu_codi=recu_codi from Lib_Recursos where recu_migr_codi=@recu_migr_codi and recu_estado='A'
		select @item_proc_codi=proc_codi from Lib_Procedencias where proc_migr_codi=@item_proc_migr_codi and proc_estado='A'

		if  @recu_codi is not null
		begin
			insert into Lib_Recursos_Items (recu_codi,item_edic,item_fech_ing,item_prec,item_proc_codi,item_estado)
				values (@recu_codi,@item_edic,@item_fech_ing,@item_prec,@item_proc_codi,'A')
			select @recu_codi=@@IDENTITY

		end
		
		
		FETCH NEXT FROM cur_recu_migr_item INTO @recu_migr_codi,@item_edic,@item_fech_ing,@item_prec,@item_proc_migr_codi
	END
	CLOSE cur_recu_migr_item
	DEALLOCATE cur_recu_migr_item

	
	exec sp_xml_removedocument @recuItem
	--/*FINAL EXTRACCION ITEMS*/--
	set nocount off

	commit transaction trans_recu_item
end try
begin catch
	rollback transaction trans_recu_item
	select error_message() as error,error_line(),error_state(),error_procedure()
end catch
END