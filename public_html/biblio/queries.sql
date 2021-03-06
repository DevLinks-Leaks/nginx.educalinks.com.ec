
Create Table Lib_Categorias (
cate_codi int IDENTITY(1,1),
cate_deta varchar(200) not null, 
cate_estado varchar(1) not null default 'A',
cate_migr_codi varchar(200) null,
CONSTRAINT PK_Categorias PRIMARY KEY (cate_codi)
);

Create Table Lib_Descriptores (
desc_codi int IDENTITY(1,1),
desc_deta varchar(200) not null, 
desc_estado varchar(1) not null default 'A',
desc_migr_codi varchar(200) null,
CONSTRAINT PK_Descriptores PRIMARY KEY (desc_codi)
);

Create Table Lib_Tipos (
tipo_codi int IDENTITY(1,1),
tipo_deta varchar(200) not null, 
tipo_estado varchar(1) not null default 'A',
tipo_default bit not null default 0,
tipo_migr_codi varchar(200) null,
CONSTRAINT PK_Tipos PRIMARY KEY (tipo_codi)
);

Create Table Lib_Autores (
auto_codi int IDENTITY(1,1),
auto_nomb varchar(200) not null, 
auto_apel varchar(200) not null, 
auto_estado varchar(1) not null default 'A',
auto_migr_codi varchar(200) null,
CONSTRAINT PK_Autores PRIMARY KEY (auto_codi)
);

Create Table Lib_Procedencias (
proc_codi int IDENTITY(1,1),
proc_deta varchar(200) not null, 
proc_estado varchar(1) not null default 'A',
proc_migr_codi varchar(200) null,
CONSTRAINT PK_Procedencias PRIMARY KEY (proc_codi)
);

Create Table Lib_Colecciones (
cole_codi int IDENTITY(1,1),
cole_deta varchar(200) not null, 
cole_estado varchar(1) not null default 'A',
cole_migr_codi varchar(200) null,
CONSTRAINT PK_Colecciones PRIMARY KEY (cole_codi)
);

Create Table Lib_Editoriales (
edit_codi int IDENTITY(1,1),
edit_deta varchar(200) not null, 
edit_estado varchar(1) not null default 'A',
edit_migr_codi varchar(200) null,
CONSTRAINT PK_Editoriales PRIMARY KEY (edit_codi)
);

Create Table Lib_Recursos (
recu_codi bigint IDENTITY(1,1),
recu_titu varchar(200) not null,
recu_isbn varchar(50) null,
recu_issn varchar(50) null,
recu_fech_publ date null,
recu_fech_regi datetime not null,
recu_vide_dura time null,
recu_vide_resu varchar(500) null,
recu_tipo_codi int not null,
recu_estado varchar(1) not null default 'A',
recu_migr_codi varchar(200) null,
CONSTRAINT FK_Recursos_Tipos FOREIGN KEY (recu_tipo_codi) REFERENCES Lib_Tipos (tipo_codi),
recu_edit_codi int null,
--CONSTRAINT FK_Recursos_Editoriales FOREIGN KEY (recu_edit_codi) REFERENCES Lib_Editoriales (edit_codi), debido a conflict con valores null
recu_cole_codi int null,
--CONSTRAINT FK_Recursos_Colecciones FOREIGN KEY (recu_cole_codi) REFERENCES Lib_Colecciones (cole_codi),
CONSTRAINT PK_Recursos PRIMARY KEY (recu_codi)
);


Create Table Lib_Recursos_Autores (
recu_codi bigint not null ,
auto_codi int not null ,
auto_tipo varchar(2) not null ,
CONSTRAINT FK_Autores FOREIGN KEY (auto_codi) REFERENCES Lib_Autores (auto_codi),
CONSTRAINT FK_Recursos FOREIGN KEY (recu_codi) REFERENCES Lib_Recursos (recu_codi),
CONSTRAINT UQ_Lib_Recursos_Autores UNIQUE (recu_codi, auto_codi, auto_tipo)
);

Create Table Lib_Recursos_Items (
item_codi bigint IDENTITY(1,1),
recu_codi bigint not null,
item_edic varchar(200) null,
item_fech_ing date not null,
item_prec numeric(18,2) null,
item_proc_codi int not null,
item_estado varchar(1) not null default 'A',
CONSTRAINT FK_Recursos_Items FOREIGN KEY (recu_codi) REFERENCES Lib_Recursos (recu_codi),
CONSTRAINT FK_Recursos_Items_Procedencias FOREIGN KEY (item_proc_codi) REFERENCES Lib_Procedencias (proc_codi),
CONSTRAINT PK_Items PRIMARY KEY (item_codi)
);


Create Table Lib_Recursos_Categorias (
recu_codi bigint not null,
cate_codi int not null,
CONSTRAINT FK_Categorias FOREIGN KEY (cate_codi) REFERENCES Lib_Categorias (cate_codi),
CONSTRAINT FK_Recursos_Categorías FOREIGN KEY (recu_codi) REFERENCES Lib_Recursos (recu_codi),
);

Create Table Lib_Recursos_Descriptores (
recu_codi bigint not null,
desc_codi int not null,
CONSTRAINT FK_Descriptores FOREIGN KEY (desc_codi) REFERENCES Lib_Descriptores (desc_codi),
CONSTRAINT FK_Recursos_Descriptores FOREIGN KEY (recu_codi) REFERENCES Lib_Recursos (recu_codi),
);

Create Table Lib_Prestamos (
pres_codi bigint IDENTITY(1,1),
pres_usua_codi varchar(50) not null,
pres_usua_tipo_codi int not null,
pres_fech_regi datetime not null,
pres_fech_devo datetime not null,
pres_obse varchar(500) null,
pres_estado varchar(1) not null default 'A',
CONSTRAINT FK_Prestamos_Usuarios_Tipos FOREIGN KEY (pres_usua_tipo_codi) REFERENCES Usuarios_Tipos (usua_tipo_codi),
CONSTRAINT PK_Prestamos PRIMARY KEY (pres_codi)
);

Create Table Lib_Prestamos_Items (
pres_item_codi bigint IDENTITY(1,1),
pres_codi bigint not null,
item_codi bigint not null,
pres_item_fech_reto datetime null,
pres_item_estado varchar(1) not null default 'A',
CONSTRAINT FK_Prestamos_Items_Prestamos FOREIGN KEY (pres_codi) REFERENCES Lib_Prestamos (pres_codi),
CONSTRAINT FK_Prestamos_Items_Items FOREIGN KEY (item_codi) REFERENCES Lib_Recursos_Items (item_codi),
CONSTRAINT PK_Prestamos_Items PRIMARY KEY (pres_item_codi)
);


--select * from permisos

--select * from auditoria_tipos

INSERT INTO Auditoria_Tipos VALUES (300,'CREAR RECURSO','A','BIB')
									,(301,'EDITAR RECURSO','A','BIB')
									,(302,'ELIMINAR RECURSO','A','BIB')
									,(303,'CREAR ITEM RECURSO','A','BIB')
									,(304,'EDITAR ITEM RECURSO','A','BIB')
									,(305,'ELIMINAR ITEM RECURSO','A','BIB')
									,(306,'CREAR PRESTAMO RECURSO','A','BIB')
									,(307,'EDITAR PRESTAMO RECURSO','A','BIB')
									,(308,'ELIMINAR PRESTAMO RECURSO','A','BIB')
									,(309,'DEVOLUCION PRESTAMO RECURSO ITEM','A','BIB')
									,(310,'IMPORTACIÓN DE RECURSOS LIBROS','A','BIB')
									,(311,'IMPORTACIÓN DE RECURSOS REVISTAS','A','BIB')
									,(312,'IMPORTACIÓN DE RECURSOS VIDEOS','A','BIB')
									,(313,'IMPORTACIÓN DE RECURSOS OTROS','A','BIB')
									,(314,'IMPORTACIÓN DE RECURSOS ITEMS','A','BIB')
									,(315,'IMPORTACIÓN DE AUTORES','A','BIB')
									,(316,'IMPORTACIÓN DE CATEGORIAS','A','BIB')
									,(317,'IMPORTACIÓN DE DESCRIPTORES','A','BIB')
									,(318,'IMPORTACIÓN DE TIPOS','A','BIB')
									,(319,'IMPORTACIÓN DE COLECCIONES','A','BIB')
									,(320,'IMPORTACIÓN DE EDITORIALES','A','BIB')
									,(321,'IMPORTACIÓN DE PROCEDENCIAS','A','BIB')
INSERT INTO Lib_Tipos values ('LIBRO','A',1,NULL)
								,('REVISTA','A',1,NULL)
								,('VIDEOS','A',1,NULL)


--drop table Lib_Libros_Categorias

--drop table Lib_Prestamos

--drop table Lib_Libros_Ejemplares

--drop table Lib_Libros

--drop table Lib_Tipos

--drop table Lib_Categorias

--drop table Lib_Autores

--drop table Lib_Procedencia

--drop table Lib_Colecciones

--drop table Lib_Editoriales

--drop table Lib_Libros_Tipos




--drop table Lib_Recursos_Autores

--drop table Lib_Recursos_Items

--drop table Lib_Prestamos_Items

--exec sp_who2
