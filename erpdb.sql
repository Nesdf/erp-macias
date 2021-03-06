PGDMP     !                    v            ddmr0crgm74dd4     10.2 (Ubuntu 10.2-1.pgdg14.04+1)    10.3 �    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false            �           1262    7183166    ddmr0crgm74dd4    DATABASE     �   CREATE DATABASE ddmr0crgm74dd4 WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';
    DROP DATABASE ddmr0crgm74dd4;
             qdavzziegxenuj    false                        2615    7666892    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             qdavzziegxenuj    false                        3079    13809    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            �           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    1            �           0    0    LANGUAGE plpgsql    ACL     1   GRANT ALL ON LANGUAGE plpgsql TO qdavzziegxenuj;
                  postgres    false    738            �            1259    7776738    actor_personaje    TABLE       CREATE TABLE public.actor_personaje (
    id integer NOT NULL,
    episodio_folio character varying(10),
    personaje character varying(255),
    fijo boolean,
    proyecto boolean,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);
 #   DROP TABLE public.actor_personaje;
       public         qdavzziegxenuj    false    3            �            1259    7776736    actor_personaje_id_seq    SEQUENCE     �   CREATE SEQUENCE public.actor_personaje_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.actor_personaje_id_seq;
       public       qdavzziegxenuj    false    244    3            �           0    0    actor_personaje_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.actor_personaje_id_seq OWNED BY public.actor_personaje.id;
            public       qdavzziegxenuj    false    243            �            1259    7667680    actores    TABLE       CREATE TABLE public.actores (
    id integer NOT NULL,
    nombre_completo character varying(150) NOT NULL,
    nombre_artistico character varying(50) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.actores;
       public         qdavzziegxenuj    false    3            �            1259    7667678    actores_id_seq    SEQUENCE     �   CREATE SEQUENCE public.actores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.actores_id_seq;
       public       qdavzziegxenuj    false    3    236            �           0    0    actores_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.actores_id_seq OWNED BY public.actores.id;
            public       qdavzziegxenuj    false    235            �            1259    7667650 
   calendario    TABLE     �  CREATE TABLE public.calendario (
    id integer NOT NULL,
    actor character varying(50) NOT NULL,
    cita_start character varying(50) NOT NULL,
    cita_end character varying(50) NOT NULL,
    folio_id character varying(20),
    estatus_grupo boolean NOT NULL,
    estatus boolean NOT NULL,
    descripcion text NOT NULL,
    director character varying(50) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.calendario;
       public         qdavzziegxenuj    false    3            �            1259    7667648    calendario_id_seq    SEQUENCE     �   CREATE SEQUENCE public.calendario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.calendario_id_seq;
       public       qdavzziegxenuj    false    230    3            �           0    0    calendario_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.calendario_id_seq OWNED BY public.calendario.id;
            public       qdavzziegxenuj    false    229            �            1259    7667612    calificar_materiales    TABLE     �  CREATE TABLE public.calificar_materiales (
    id integer NOT NULL,
    correo_activo character varying(100),
    duracion character varying(25),
    tipo_reporte character varying(100),
    mezcla character varying(100),
    tcr integer,
    id_episodio integer NOT NULL,
    descripcion text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 (   DROP TABLE public.calificar_materiales;
       public         qdavzziegxenuj    false    3            �            1259    7667610    calificar_materiales_id_seq    SEQUENCE     �   CREATE SEQUENCE public.calificar_materiales_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.calificar_materiales_id_seq;
       public       qdavzziegxenuj    false    3    222            �           0    0    calificar_materiales_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.calificar_materiales_id_seq OWNED BY public.calificar_materiales.id;
            public       qdavzziegxenuj    false    221            �            1259    7667558    clientes    TABLE     2  CREATE TABLE public.clientes (
    id integer NOT NULL,
    razon_social character varying(100) NOT NULL,
    rfc character varying(15) NOT NULL,
    "paisId" integer NOT NULL,
    "estadoId" integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.clientes;
       public         qdavzziegxenuj    false    3            �            1259    7667556    clientes_id_seq    SEQUENCE     �   CREATE SEQUENCE public.clientes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.clientes_id_seq;
       public       qdavzziegxenuj    false    3    210            �           0    0    clientes_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.clientes_id_seq OWNED BY public.clientes.id;
            public       qdavzziegxenuj    false    209            �            1259    7667547 	   episodios    TABLE     _  CREATE TABLE public.episodios (
    id integer NOT NULL,
    titulo_original character varying(200),
    date_entrega date,
    "salaId" integer,
    "directorId" integer,
    productor character varying(200),
    responsable character varying(200),
    validador_traductor boolean,
    fecha_asignacion_traductor date,
    fecha_doblaje date,
    quien_modifico_productor text,
    quien_modifico_traductor text,
    fecha_entrega_traductor date,
    fecha_erayado date,
    fecha_aprobacion_cliente date,
    sin_script boolean,
    aprobacion_cliente boolean,
    rayado boolean,
    status_coordinador boolean,
    "traductorId" integer,
    num_episodio character varying(191),
    "proyectoId" integer NOT NULL,
    date_m_and_e date,
    material_calificado boolean,
    bw boolean,
    netcut boolean,
    lockcut boolean,
    final boolean,
    date_bw date,
    date_netcut date,
    date_lockcut date,
    date_final date,
    configuracion text,
    folio character varying(191) NOT NULL,
    chk_canciones boolean,
    chk_subtitulos boolean,
    chk_lenguaje_diferente_original boolean,
    chk_qc boolean,
    chk_reprobacion boolean,
    chk_edicion boolean,
    fecha_edicion date,
    nombre_regrabador date,
    nombre_editor date,
    fecha_regrabacion date,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.episodios;
       public         qdavzziegxenuj    false    3            �            1259    7667545    episodios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.episodios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.episodios_id_seq;
       public       qdavzziegxenuj    false    208    3            �           0    0    episodios_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.episodios_id_seq OWNED BY public.episodios.id;
            public       qdavzziegxenuj    false    207            �            1259    7667521    estados    TABLE     �   CREATE TABLE public.estados (
    id integer NOT NULL,
    estado character varying(30) NOT NULL,
    "paisesId" integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.estados;
       public         qdavzziegxenuj    false    3            �            1259    7667519    estados_id_seq    SEQUENCE     �   CREATE SEQUENCE public.estados_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.estados_id_seq;
       public       qdavzziegxenuj    false    204    3            �           0    0    estados_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.estados_id_seq OWNED BY public.estados.id;
            public       qdavzziegxenuj    false    203            �            1259    7667690    estudios    TABLE     �   CREATE TABLE public.estudios (
    id integer NOT NULL,
    estudio character varying(150) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.estudios;
       public         qdavzziegxenuj    false    3            �            1259    7667688    estudios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.estudios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.estudios_id_seq;
       public       qdavzziegxenuj    false    3    238            �           0    0    estudios_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.estudios_id_seq OWNED BY public.estudios.id;
            public       qdavzziegxenuj    false    237            �            1259    7667672    folio_actores    TABLE     �   CREATE TABLE public.folio_actores (
    id integer NOT NULL,
    folio character varying(20) NOT NULL,
    actor_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.folio_actores;
       public         qdavzziegxenuj    false    3            �            1259    7667670    folio_actores_id_seq    SEQUENCE     �   CREATE SEQUENCE public.folio_actores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.folio_actores_id_seq;
       public       qdavzziegxenuj    false    234    3            �           0    0    folio_actores_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.folio_actores_id_seq OWNED BY public.folio_actores.id;
            public       qdavzziegxenuj    false    233            �            1259    7667578    idiomas    TABLE     �   CREATE TABLE public.idiomas (
    id integer NOT NULL,
    idioma character varying(30) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.idiomas;
       public         qdavzziegxenuj    false    3            �            1259    7667576    idiomas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.idiomas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.idiomas_id_seq;
       public       qdavzziegxenuj    false    214    3            �           0    0    idiomas_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.idiomas_id_seq OWNED BY public.idiomas.id;
            public       qdavzziegxenuj    false    213            �            1259    7667596    jobs    TABLE     �   CREATE TABLE public.jobs (
    id integer NOT NULL,
    job character varying(100) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.jobs;
       public         qdavzziegxenuj    false    3            �            1259    7667594    jobs_id_seq    SEQUENCE     �   CREATE SEQUENCE public.jobs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.jobs_id_seq;
       public       qdavzziegxenuj    false    3    218            �           0    0    jobs_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;
            public       qdavzziegxenuj    false    217            �            1259    7667661    llamado    TABLE     �  CREATE TABLE public.llamado (
    id integer NOT NULL,
    actor character varying(255) NOT NULL,
    credencial character varying(10) NOT NULL,
    loops character varying(10) NOT NULL,
    sala character varying(50) NOT NULL,
    director character varying(255) NOT NULL,
    folio character varying(20) NOT NULL,
    capitulo character varying(20) NOT NULL,
    cita_start timestamp(0) without time zone NOT NULL,
    cita_end timestamp(0) without time zone NOT NULL,
    estatus_grupo boolean NOT NULL,
    descripcion text NOT NULL,
    estatus boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.llamado;
       public         qdavzziegxenuj    false    3            �            1259    7667659    llamado_id_seq    SEQUENCE     �   CREATE SEQUENCE public.llamado_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.llamado_id_seq;
       public       qdavzziegxenuj    false    3    232            �           0    0    llamado_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.llamado_id_seq OWNED BY public.llamado.id;
            public       qdavzziegxenuj    false    231            �            1259    7667484 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(191) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         qdavzziegxenuj    false    3            �            1259    7667482    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public       qdavzziegxenuj    false    3    197            �           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
            public       qdavzziegxenuj    false    196            �            1259    7667509    paises    TABLE     �   CREATE TABLE public.paises (
    id integer NOT NULL,
    pais character varying(30) NOT NULL,
    surname character varying(30) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.paises;
       public         qdavzziegxenuj    false    3            �            1259    7667507    paises_id_seq    SEQUENCE     �   CREATE SEQUENCE public.paises_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.paises_id_seq;
       public       qdavzziegxenuj    false    3    202            �           0    0    paises_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.paises_id_seq OWNED BY public.paises.id;
            public       qdavzziegxenuj    false    201            �            1259    7667503    password_resets    TABLE     �   CREATE TABLE public.password_resets (
    email character varying(191) NOT NULL,
    token character varying(191) NOT NULL,
    created_at timestamp(0) without time zone
);
 #   DROP TABLE public.password_resets;
       public         qdavzziegxenuj    false    3            �            1259    7667536 	   proyectos    TABLE     �  CREATE TABLE public.proyectos (
    id integer NOT NULL,
    titulo_original character varying(200),
    titulo_aprobado character varying(200),
    m_and_e boolean,
    "statusId" integer NOT NULL,
    "clienteId" integer NOT NULL,
    titulo_espanol character varying(200),
    titulo_ingles character varying(200),
    titulo_portugues character varying(200),
    temporada character varying(200),
    "viaId" integer,
    otro_formato character varying(191),
    observaciones text,
    adr_ingles boolean,
    adr_espanol boolean,
    adr_portugues boolean,
    mix20 boolean,
    mix51 boolean,
    mix71 boolean,
    relleno_mande boolean,
    m_e_20 boolean,
    m_e_51 boolean,
    m_e_71 boolean,
    subt_espanol boolean,
    subt_ingles boolean,
    subt_portugues boolean,
    material_entregado boolean,
    fecha_llegada date,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.proyectos;
       public         qdavzziegxenuj    false    3            �            1259    7667534    proyectos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.proyectos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.proyectos_id_seq;
       public       qdavzziegxenuj    false    3    206            �           0    0    proyectos_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.proyectos_id_seq OWNED BY public.proyectos.id;
            public       qdavzziegxenuj    false    205            �            1259    7667642    routes_access    TABLE     �   CREATE TABLE public.routes_access (
    id integer NOT NULL,
    alias_name character varying(50) NOT NULL,
    user_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.routes_access;
       public         qdavzziegxenuj    false    3            �            1259    7667640    routes_access_id_seq    SEQUENCE     �   CREATE SEQUENCE public.routes_access_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.routes_access_id_seq;
       public       qdavzziegxenuj    false    3    228            �           0    0    routes_access_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.routes_access_id_seq OWNED BY public.routes_access.id;
            public       qdavzziegxenuj    false    227            �            1259    7667604    salas    TABLE     �   CREATE TABLE public.salas (
    id integer NOT NULL,
    sala character varying(30) NOT NULL,
    estudio_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.salas;
       public         qdavzziegxenuj    false    3            �            1259    7667602    salas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.salas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.salas_id_seq;
       public       qdavzziegxenuj    false    3    220            �           0    0    salas_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.salas_id_seq OWNED BY public.salas.id;
            public       qdavzziegxenuj    false    219            �            1259    7667568    status    TABLE     �   CREATE TABLE public.status (
    id integer NOT NULL,
    status character varying(191) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.status;
       public         qdavzziegxenuj    false    3            �            1259    7667566    status_id_seq    SEQUENCE     �   CREATE SEQUENCE public.status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.status_id_seq;
       public       qdavzziegxenuj    false    3    212            �           0    0    status_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.status_id_seq OWNED BY public.status.id;
            public       qdavzziegxenuj    false    211            �            1259    7667634    tcrs    TABLE     �   CREATE TABLE public.tcrs (
    id integer NOT NULL,
    tcr character varying(25) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.tcrs;
       public         qdavzziegxenuj    false    3            �            1259    7667632    tcrs_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tcrs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.tcrs_id_seq;
       public       qdavzziegxenuj    false    226    3            �           0    0    tcrs_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.tcrs_id_seq OWNED BY public.tcrs.id;
            public       qdavzziegxenuj    false    225            �            1259    7667623    timecode    TABLE     :  CREATE TABLE public.timecode (
    id integer NOT NULL,
    fecha date,
    timecode character varying(11) NOT NULL,
    timecode_final character varying(11),
    observaciones text,
    id_calificar_material integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.timecode;
       public         qdavzziegxenuj    false    3            �            1259    7667621    timecode_id_seq    SEQUENCE     �   CREATE SEQUENCE public.timecode_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.timecode_id_seq;
       public       qdavzziegxenuj    false    3    224            �           0    0    timecode_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.timecode_id_seq OWNED BY public.timecode.id;
            public       qdavzziegxenuj    false    223            �            1259    7667710 	   timecodes    TABLE     �   CREATE TABLE public.timecodes (
    id integer NOT NULL,
    timecode character varying(150) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.timecodes;
       public         qdavzziegxenuj    false    3            �            1259    7667708    timecodes_id_seq    SEQUENCE     �   CREATE SEQUENCE public.timecodes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.timecodes_id_seq;
       public       qdavzziegxenuj    false    3    242            �           0    0    timecodes_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.timecodes_id_seq OWNED BY public.timecodes.id;
            public       qdavzziegxenuj    false    241            �            1259    7667700    tipo_reportes    TABLE     �   CREATE TABLE public.tipo_reportes (
    id integer NOT NULL,
    tipo character varying(150) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 !   DROP TABLE public.tipo_reportes;
       public         qdavzziegxenuj    false    3            �            1259    7667698    tipo_reportes_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tipo_reportes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.tipo_reportes_id_seq;
       public       qdavzziegxenuj    false    240    3            �           0    0    tipo_reportes_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.tipo_reportes_id_seq OWNED BY public.tipo_reportes.id;
            public       qdavzziegxenuj    false    239            �            1259    7667492    users    TABLE     �  CREATE TABLE public.users (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    ap_paterno character varying(50) NOT NULL,
    ap_materno character varying(50) NOT NULL,
    email character varying(191) NOT NULL,
    password character varying(70) NOT NULL,
    tipo_empleado boolean NOT NULL,
    job integer NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.users;
       public         qdavzziegxenuj    false    3            �            1259    7667490    users_id_seq    SEQUENCE     �   CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public       qdavzziegxenuj    false    3    199            �           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
            public       qdavzziegxenuj    false    198            �            1259    7667588    vias    TABLE     �   CREATE TABLE public.vias (
    id integer NOT NULL,
    via character varying(191) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.vias;
       public         qdavzziegxenuj    false    3            �            1259    7667586    vias_id_seq    SEQUENCE     �   CREATE SEQUENCE public.vias_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.vias_id_seq;
       public       qdavzziegxenuj    false    216    3            �           0    0    vias_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.vias_id_seq OWNED BY public.vias.id;
            public       qdavzziegxenuj    false    215            �           2604    7776741    actor_personaje id    DEFAULT     x   ALTER TABLE ONLY public.actor_personaje ALTER COLUMN id SET DEFAULT nextval('public.actor_personaje_id_seq'::regclass);
 A   ALTER TABLE public.actor_personaje ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    244    243    244            �           2604    7667683 
   actores id    DEFAULT     h   ALTER TABLE ONLY public.actores ALTER COLUMN id SET DEFAULT nextval('public.actores_id_seq'::regclass);
 9   ALTER TABLE public.actores ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    236    235    236            �           2604    7667653    calendario id    DEFAULT     n   ALTER TABLE ONLY public.calendario ALTER COLUMN id SET DEFAULT nextval('public.calendario_id_seq'::regclass);
 <   ALTER TABLE public.calendario ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    229    230    230            �           2604    7667615    calificar_materiales id    DEFAULT     �   ALTER TABLE ONLY public.calificar_materiales ALTER COLUMN id SET DEFAULT nextval('public.calificar_materiales_id_seq'::regclass);
 F   ALTER TABLE public.calificar_materiales ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    222    221    222            }           2604    7667561    clientes id    DEFAULT     j   ALTER TABLE ONLY public.clientes ALTER COLUMN id SET DEFAULT nextval('public.clientes_id_seq'::regclass);
 :   ALTER TABLE public.clientes ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    209    210    210            |           2604    7667550    episodios id    DEFAULT     l   ALTER TABLE ONLY public.episodios ALTER COLUMN id SET DEFAULT nextval('public.episodios_id_seq'::regclass);
 ;   ALTER TABLE public.episodios ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    208    207    208            z           2604    7667524 
   estados id    DEFAULT     h   ALTER TABLE ONLY public.estados ALTER COLUMN id SET DEFAULT nextval('public.estados_id_seq'::regclass);
 9   ALTER TABLE public.estados ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    203    204    204            �           2604    7667693    estudios id    DEFAULT     j   ALTER TABLE ONLY public.estudios ALTER COLUMN id SET DEFAULT nextval('public.estudios_id_seq'::regclass);
 :   ALTER TABLE public.estudios ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    238    237    238            �           2604    7667675    folio_actores id    DEFAULT     t   ALTER TABLE ONLY public.folio_actores ALTER COLUMN id SET DEFAULT nextval('public.folio_actores_id_seq'::regclass);
 ?   ALTER TABLE public.folio_actores ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    234    233    234                       2604    7667581 
   idiomas id    DEFAULT     h   ALTER TABLE ONLY public.idiomas ALTER COLUMN id SET DEFAULT nextval('public.idiomas_id_seq'::regclass);
 9   ALTER TABLE public.idiomas ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    214    213    214            �           2604    7667599    jobs id    DEFAULT     b   ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);
 6   ALTER TABLE public.jobs ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    218    217    218            �           2604    7667664 
   llamado id    DEFAULT     h   ALTER TABLE ONLY public.llamado ALTER COLUMN id SET DEFAULT nextval('public.llamado_id_seq'::regclass);
 9   ALTER TABLE public.llamado ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    232    231    232            w           2604    7667487    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    196    197    197            y           2604    7667512 	   paises id    DEFAULT     f   ALTER TABLE ONLY public.paises ALTER COLUMN id SET DEFAULT nextval('public.paises_id_seq'::regclass);
 8   ALTER TABLE public.paises ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    201    202    202            {           2604    7667539    proyectos id    DEFAULT     l   ALTER TABLE ONLY public.proyectos ALTER COLUMN id SET DEFAULT nextval('public.proyectos_id_seq'::regclass);
 ;   ALTER TABLE public.proyectos ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    206    205    206            �           2604    7667645    routes_access id    DEFAULT     t   ALTER TABLE ONLY public.routes_access ALTER COLUMN id SET DEFAULT nextval('public.routes_access_id_seq'::regclass);
 ?   ALTER TABLE public.routes_access ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    228    227    228            �           2604    7667607    salas id    DEFAULT     d   ALTER TABLE ONLY public.salas ALTER COLUMN id SET DEFAULT nextval('public.salas_id_seq'::regclass);
 7   ALTER TABLE public.salas ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    220    219    220            ~           2604    7667571 	   status id    DEFAULT     f   ALTER TABLE ONLY public.status ALTER COLUMN id SET DEFAULT nextval('public.status_id_seq'::regclass);
 8   ALTER TABLE public.status ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    211    212    212            �           2604    7667637    tcrs id    DEFAULT     b   ALTER TABLE ONLY public.tcrs ALTER COLUMN id SET DEFAULT nextval('public.tcrs_id_seq'::regclass);
 6   ALTER TABLE public.tcrs ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    226    225    226            �           2604    7667626    timecode id    DEFAULT     j   ALTER TABLE ONLY public.timecode ALTER COLUMN id SET DEFAULT nextval('public.timecode_id_seq'::regclass);
 :   ALTER TABLE public.timecode ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    224    223    224            �           2604    7667713    timecodes id    DEFAULT     l   ALTER TABLE ONLY public.timecodes ALTER COLUMN id SET DEFAULT nextval('public.timecodes_id_seq'::regclass);
 ;   ALTER TABLE public.timecodes ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    242    241    242            �           2604    7667703    tipo_reportes id    DEFAULT     t   ALTER TABLE ONLY public.tipo_reportes ALTER COLUMN id SET DEFAULT nextval('public.tipo_reportes_id_seq'::regclass);
 ?   ALTER TABLE public.tipo_reportes ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    240    239    240            x           2604    7667495    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    198    199    199            �           2604    7667591    vias id    DEFAULT     b   ALTER TABLE ONLY public.vias ALTER COLUMN id SET DEFAULT nextval('public.vias_id_seq'::regclass);
 6   ALTER TABLE public.vias ALTER COLUMN id DROP DEFAULT;
       public       qdavzziegxenuj    false    215    216    216            �          0    7776738    actor_personaje 
   TABLE DATA               p   COPY public.actor_personaje (id, episodio_folio, personaje, fijo, proyecto, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    244   3�       x          0    7667680    actores 
   TABLE DATA               `   COPY public.actores (id, nombre_completo, nombre_artistico, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    236   P�       r          0    7667650 
   calendario 
   TABLE DATA               �   COPY public.calendario (id, actor, cita_start, cita_end, folio_id, estatus_grupo, estatus, descripcion, director, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    230   w�       j          0    7667612    calificar_materiales 
   TABLE DATA               �   COPY public.calificar_materiales (id, correo_activo, duracion, tipo_reporte, mezcla, tcr, id_episodio, descripcion, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    222   ��       ^          0    7667558    clientes 
   TABLE DATA               g   COPY public.clientes (id, razon_social, rfc, "paisId", "estadoId", created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    210   ��       \          0    7667547 	   episodios 
   TABLE DATA               �  COPY public.episodios (id, titulo_original, date_entrega, "salaId", "directorId", productor, responsable, validador_traductor, fecha_asignacion_traductor, fecha_doblaje, quien_modifico_productor, quien_modifico_traductor, fecha_entrega_traductor, fecha_erayado, fecha_aprobacion_cliente, sin_script, aprobacion_cliente, rayado, status_coordinador, "traductorId", num_episodio, "proyectoId", date_m_and_e, material_calificado, bw, netcut, lockcut, final, date_bw, date_netcut, date_lockcut, date_final, configuracion, folio, chk_canciones, chk_subtitulos, chk_lenguaje_diferente_original, chk_qc, chk_reprobacion, chk_edicion, fecha_edicion, nombre_regrabador, nombre_editor, fecha_regrabacion, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    208   ��       X          0    7667521    estados 
   TABLE DATA               Q   COPY public.estados (id, estado, "paisesId", created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    204   ��       z          0    7667690    estudios 
   TABLE DATA               G   COPY public.estudios (id, estudio, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    238   I�       v          0    7667672    folio_actores 
   TABLE DATA               T   COPY public.folio_actores (id, folio, actor_id, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    234   ��       b          0    7667578    idiomas 
   TABLE DATA               E   COPY public.idiomas (id, idioma, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    214   ��       f          0    7667596    jobs 
   TABLE DATA               ?   COPY public.jobs (id, job, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    218   ��       t          0    7667661    llamado 
   TABLE DATA               �   COPY public.llamado (id, actor, credencial, loops, sala, director, folio, capitulo, cita_start, cita_end, estatus_grupo, descripcion, estatus, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    232   ��       Q          0    7667484 
   migrations 
   TABLE DATA               :   COPY public.migrations (id, migration, batch) FROM stdin;
    public       qdavzziegxenuj    false    197   ��       V          0    7667509    paises 
   TABLE DATA               K   COPY public.paises (id, pais, surname, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    202   ��       T          0    7667503    password_resets 
   TABLE DATA               C   COPY public.password_resets (email, token, created_at) FROM stdin;
    public       qdavzziegxenuj    false    200   ��       Z          0    7667536 	   proyectos 
   TABLE DATA               �  COPY public.proyectos (id, titulo_original, titulo_aprobado, m_and_e, "statusId", "clienteId", titulo_espanol, titulo_ingles, titulo_portugues, temporada, "viaId", otro_formato, observaciones, adr_ingles, adr_espanol, adr_portugues, mix20, mix51, mix71, relleno_mande, m_e_20, m_e_51, m_e_71, subt_espanol, subt_ingles, subt_portugues, material_entregado, fecha_llegada, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    206   
�       p          0    7667642    routes_access 
   TABLE DATA               X   COPY public.routes_access (id, alias_name, user_id, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    228   '�       h          0    7667604    salas 
   TABLE DATA               M   COPY public.salas (id, sala, estudio_id, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    220   ��       `          0    7667568    status 
   TABLE DATA               D   COPY public.status (id, status, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    212   ��       n          0    7667634    tcrs 
   TABLE DATA               ?   COPY public.tcrs (id, tcr, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    226   ��       l          0    7667623    timecode 
   TABLE DATA               �   COPY public.timecode (id, fecha, timecode, timecode_final, observaciones, id_calificar_material, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    224   �       ~          0    7667710 	   timecodes 
   TABLE DATA               I   COPY public.timecodes (id, timecode, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    242   <�       |          0    7667700    tipo_reportes 
   TABLE DATA               I   COPY public.tipo_reportes (id, tipo, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    240   Y�       S          0    7667492    users 
   TABLE DATA               �   COPY public.users (id, name, ap_paterno, ap_materno, email, password, tipo_empleado, job, remember_token, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    199   v�       d          0    7667588    vias 
   TABLE DATA               ?   COPY public.vias (id, via, created_at, updated_at) FROM stdin;
    public       qdavzziegxenuj    false    216   ��       �           0    0    actor_personaje_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.actor_personaje_id_seq', 1, false);
            public       qdavzziegxenuj    false    243            �           0    0    actores_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.actores_id_seq', 18, true);
            public       qdavzziegxenuj    false    235            �           0    0    calendario_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.calendario_id_seq', 1, false);
            public       qdavzziegxenuj    false    229            �           0    0    calificar_materiales_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.calificar_materiales_id_seq', 1, false);
            public       qdavzziegxenuj    false    221            �           0    0    clientes_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.clientes_id_seq', 1, false);
            public       qdavzziegxenuj    false    209            �           0    0    episodios_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.episodios_id_seq', 1, false);
            public       qdavzziegxenuj    false    207            �           0    0    estados_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.estados_id_seq', 3, true);
            public       qdavzziegxenuj    false    203            �           0    0    estudios_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.estudios_id_seq', 4, true);
            public       qdavzziegxenuj    false    237            �           0    0    folio_actores_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.folio_actores_id_seq', 30, true);
            public       qdavzziegxenuj    false    233            �           0    0    idiomas_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.idiomas_id_seq', 1, false);
            public       qdavzziegxenuj    false    213            �           0    0    jobs_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.jobs_id_seq', 12, true);
            public       qdavzziegxenuj    false    217            �           0    0    llamado_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.llamado_id_seq', 1, false);
            public       qdavzziegxenuj    false    231            �           0    0    migrations_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.migrations_id_seq', 23, true);
            public       qdavzziegxenuj    false    196            �           0    0    paises_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.paises_id_seq', 3, true);
            public       qdavzziegxenuj    false    201            �           0    0    proyectos_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.proyectos_id_seq', 1, false);
            public       qdavzziegxenuj    false    205            �           0    0    routes_access_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.routes_access_id_seq', 186, true);
            public       qdavzziegxenuj    false    227            �           0    0    salas_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.salas_id_seq', 20, true);
            public       qdavzziegxenuj    false    219            �           0    0    status_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.status_id_seq', 1, false);
            public       qdavzziegxenuj    false    211            �           0    0    tcrs_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('public.tcrs_id_seq', 5, true);
            public       qdavzziegxenuj    false    225            �           0    0    timecode_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.timecode_id_seq', 1, false);
            public       qdavzziegxenuj    false    223            �           0    0    timecodes_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.timecodes_id_seq', 1, false);
            public       qdavzziegxenuj    false    241            �           0    0    tipo_reportes_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.tipo_reportes_id_seq', 1, false);
            public       qdavzziegxenuj    false    239            �           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 13, true);
            public       qdavzziegxenuj    false    198            �           0    0    vias_id_seq    SEQUENCE SET     9   SELECT pg_catalog.setval('public.vias_id_seq', 6, true);
            public       qdavzziegxenuj    false    215            �           2606    7776743 $   actor_personaje actor_personaje_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.actor_personaje
    ADD CONSTRAINT actor_personaje_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.actor_personaje DROP CONSTRAINT actor_personaje_pkey;
       public         qdavzziegxenuj    false    244            �           2606    7667687 &   actores actores_nombre_completo_unique 
   CONSTRAINT     l   ALTER TABLE ONLY public.actores
    ADD CONSTRAINT actores_nombre_completo_unique UNIQUE (nombre_completo);
 P   ALTER TABLE ONLY public.actores DROP CONSTRAINT actores_nombre_completo_unique;
       public         qdavzziegxenuj    false    236            �           2606    7667685    actores actores_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.actores
    ADD CONSTRAINT actores_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.actores DROP CONSTRAINT actores_pkey;
       public         qdavzziegxenuj    false    236            �           2606    7667658    calendario calendario_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.calendario
    ADD CONSTRAINT calendario_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.calendario DROP CONSTRAINT calendario_pkey;
       public         qdavzziegxenuj    false    230            �           2606    7667620 .   calificar_materiales calificar_materiales_pkey 
   CONSTRAINT     l   ALTER TABLE ONLY public.calificar_materiales
    ADD CONSTRAINT calificar_materiales_pkey PRIMARY KEY (id);
 X   ALTER TABLE ONLY public.calificar_materiales DROP CONSTRAINT calificar_materiales_pkey;
       public         qdavzziegxenuj    false    222            �           2606    7667563    clientes clientes_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_pkey;
       public         qdavzziegxenuj    false    210            �           2606    7667565 %   clientes clientes_razon_social_unique 
   CONSTRAINT     h   ALTER TABLE ONLY public.clientes
    ADD CONSTRAINT clientes_razon_social_unique UNIQUE (razon_social);
 O   ALTER TABLE ONLY public.clientes DROP CONSTRAINT clientes_razon_social_unique;
       public         qdavzziegxenuj    false    210            �           2606    7667555    episodios episodios_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.episodios
    ADD CONSTRAINT episodios_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.episodios DROP CONSTRAINT episodios_pkey;
       public         qdavzziegxenuj    false    208            �           2606    7667533    estados estados_estado_unique 
   CONSTRAINT     Z   ALTER TABLE ONLY public.estados
    ADD CONSTRAINT estados_estado_unique UNIQUE (estado);
 G   ALTER TABLE ONLY public.estados DROP CONSTRAINT estados_estado_unique;
       public         qdavzziegxenuj    false    204            �           2606    7667526    estados estados_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.estados
    ADD CONSTRAINT estados_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.estados DROP CONSTRAINT estados_pkey;
       public         qdavzziegxenuj    false    204            �           2606    7667697     estudios estudios_estudio_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.estudios
    ADD CONSTRAINT estudios_estudio_unique UNIQUE (estudio);
 J   ALTER TABLE ONLY public.estudios DROP CONSTRAINT estudios_estudio_unique;
       public         qdavzziegxenuj    false    238            �           2606    7667695    estudios estudios_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.estudios
    ADD CONSTRAINT estudios_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.estudios DROP CONSTRAINT estudios_pkey;
       public         qdavzziegxenuj    false    238            �           2606    7667677     folio_actores folio_actores_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.folio_actores
    ADD CONSTRAINT folio_actores_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.folio_actores DROP CONSTRAINT folio_actores_pkey;
       public         qdavzziegxenuj    false    234            �           2606    7667585    idiomas idiomas_idioma_unique 
   CONSTRAINT     Z   ALTER TABLE ONLY public.idiomas
    ADD CONSTRAINT idiomas_idioma_unique UNIQUE (idioma);
 G   ALTER TABLE ONLY public.idiomas DROP CONSTRAINT idiomas_idioma_unique;
       public         qdavzziegxenuj    false    214            �           2606    7667583    idiomas idiomas_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.idiomas
    ADD CONSTRAINT idiomas_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.idiomas DROP CONSTRAINT idiomas_pkey;
       public         qdavzziegxenuj    false    214            �           2606    7667601    jobs jobs_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.jobs DROP CONSTRAINT jobs_pkey;
       public         qdavzziegxenuj    false    218            �           2606    7667669    llamado llamado_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.llamado
    ADD CONSTRAINT llamado_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.llamado DROP CONSTRAINT llamado_pkey;
       public         qdavzziegxenuj    false    232            �           2606    7667489    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public         qdavzziegxenuj    false    197            �           2606    7667516    paises paises_pais_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.paises
    ADD CONSTRAINT paises_pais_unique UNIQUE (pais);
 C   ALTER TABLE ONLY public.paises DROP CONSTRAINT paises_pais_unique;
       public         qdavzziegxenuj    false    202            �           2606    7667514    paises paises_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.paises
    ADD CONSTRAINT paises_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.paises DROP CONSTRAINT paises_pkey;
       public         qdavzziegxenuj    false    202            �           2606    7667518    paises paises_surname_unique 
   CONSTRAINT     Z   ALTER TABLE ONLY public.paises
    ADD CONSTRAINT paises_surname_unique UNIQUE (surname);
 F   ALTER TABLE ONLY public.paises DROP CONSTRAINT paises_surname_unique;
       public         qdavzziegxenuj    false    202            �           2606    7667544    proyectos proyectos_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.proyectos
    ADD CONSTRAINT proyectos_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.proyectos DROP CONSTRAINT proyectos_pkey;
       public         qdavzziegxenuj    false    206            �           2606    7667647     routes_access routes_access_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.routes_access
    ADD CONSTRAINT routes_access_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.routes_access DROP CONSTRAINT routes_access_pkey;
       public         qdavzziegxenuj    false    228            �           2606    7667609    salas salas_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.salas
    ADD CONSTRAINT salas_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.salas DROP CONSTRAINT salas_pkey;
       public         qdavzziegxenuj    false    220            �           2606    7667573    status status_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.status
    ADD CONSTRAINT status_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.status DROP CONSTRAINT status_pkey;
       public         qdavzziegxenuj    false    212            �           2606    7667575    status status_status_unique 
   CONSTRAINT     X   ALTER TABLE ONLY public.status
    ADD CONSTRAINT status_status_unique UNIQUE (status);
 E   ALTER TABLE ONLY public.status DROP CONSTRAINT status_status_unique;
       public         qdavzziegxenuj    false    212            �           2606    7667639    tcrs tcrs_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.tcrs
    ADD CONSTRAINT tcrs_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.tcrs DROP CONSTRAINT tcrs_pkey;
       public         qdavzziegxenuj    false    226            �           2606    7667631    timecode timecode_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.timecode
    ADD CONSTRAINT timecode_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.timecode DROP CONSTRAINT timecode_pkey;
       public         qdavzziegxenuj    false    224            �           2606    7667715    timecodes timecodes_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.timecodes
    ADD CONSTRAINT timecodes_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.timecodes DROP CONSTRAINT timecodes_pkey;
       public         qdavzziegxenuj    false    242            �           2606    7667717 #   timecodes timecodes_timecode_unique 
   CONSTRAINT     b   ALTER TABLE ONLY public.timecodes
    ADD CONSTRAINT timecodes_timecode_unique UNIQUE (timecode);
 M   ALTER TABLE ONLY public.timecodes DROP CONSTRAINT timecodes_timecode_unique;
       public         qdavzziegxenuj    false    242            �           2606    7667705     tipo_reportes tipo_reportes_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.tipo_reportes
    ADD CONSTRAINT tipo_reportes_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.tipo_reportes DROP CONSTRAINT tipo_reportes_pkey;
       public         qdavzziegxenuj    false    240            �           2606    7667707 '   tipo_reportes tipo_reportes_tipo_unique 
   CONSTRAINT     b   ALTER TABLE ONLY public.tipo_reportes
    ADD CONSTRAINT tipo_reportes_tipo_unique UNIQUE (tipo);
 Q   ALTER TABLE ONLY public.tipo_reportes DROP CONSTRAINT tipo_reportes_tipo_unique;
       public         qdavzziegxenuj    false    240            �           2606    7667502    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public         qdavzziegxenuj    false    199            �           2606    7667500    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public         qdavzziegxenuj    false    199            �           2606    7667593    vias vias_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.vias
    ADD CONSTRAINT vias_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.vias DROP CONSTRAINT vias_pkey;
       public         qdavzziegxenuj    false    216            �           1259    7667506    password_resets_email_index    INDEX     X   CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);
 /   DROP INDEX public.password_resets_email_index;
       public         qdavzziegxenuj    false    200            �           2606    7667527     estados estados_paisesid_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.estados
    ADD CONSTRAINT estados_paisesid_foreign FOREIGN KEY ("paisesId") REFERENCES public.paises(id) ON DELETE CASCADE;
 J   ALTER TABLE ONLY public.estados DROP CONSTRAINT estados_paisesid_foreign;
       public       qdavzziegxenuj    false    202    204    3737            �      x������ � �      x     x�mS�n�0<�_�?��nN���H� z�J�ʔ!Q�2`��99��֫~�KQ.Z���%gwFK�P�y��ºn��n�CWX�EY����b$.D
�(��a<a['��fל�Z�ڣ&�.B[0$���S�i^�l�p��'��ȺO�@�g�,�0>ak�r�.��a��2�t���t�>7�FI�Sv��1��4��P��ZU�A:C�Y��B�Pg<�a|Ʈ��
.�RZ�'
�� �"��>sL�����ݼQ�K��u�!9��1�`hJ��]ޜV��Wڰ�	}z�%�x���.�}A�22�.aE'�Mv���;��0.��Ҝ�}���6L�=E����se_i��^��}�{td��s��~�^1�v�>u����Řm��;K�j<�����d�O^g��d(�FDSM�wuk�y�<�뢢�tm��QKvma_eQ������+�_��o -��Y��BM_a���bƞ����]{=Mټj�{�RIh�Cj:�a\�٭�d���Ҕ*v{^�2M��q�� 3�g�      r      x������ � �      j      x������ � �      ^      x������ � �      \      x������ � �      X   N   x�3�tv��4�420��50�54Q02�20�25�&�e���������iD�.cΠ�k�RR��R3�H����� q�"�      z   Q   x�3�tst���420��50�54Q02�20�25�&�e�������L�&cNw'�՛p:������%F��� �>(W      v   %  x��T�q!|KQ8�u�������p�犇U5�>A7(m%%�/їƇ����06R0��;���\<7��C�N�2�a�H�����S{'mI��`<(d��v�QϤ���m/�q�[D)��cE���7�*N3�q�K`&�!U�'�J�e�Gcm�:+-�)�2VK�}0�A��+��#p'��<��`�5�����V_�z0��F/9�L,�f�+.��ũ���+j����� �V2`�oT�����m��c��Թ"5�`l�����/;�$�Yywc��3Rp�|2�/II
�      b      x������ � �      f   �   x����n�0�g�)�)$�?[�Y
�h�.�E,Ѡ����n�N�l��pw��+�QJ�V�&nfJ��n3_��%���>����_8p}7�jL��Á�B$S����*ƓiU�Ɛ]���-�zy�=K2��WzW<g%]��C��;�[��s����bgxh@�,J����3�j^�~P:�Q��V�s��a�pP¶���1���(�k���      t      x������ � �      Q   t  x�e��n� ���af8��҄�8���b ����
�zab���pCBӀ��_�2��)D��}�t�B8�����äEJ���%�fJ��7%.R��"�N1��W*���/��`uŢ`Z]��kp�b1���虚����KùߴU9�$r��!]~�b*v��?�3�Aqy�y�B�����@|�Q�^C�ǜ�Ѧ��W�*��0�0��7�{8k�^�cpf�e�\��,�����bY�BJ(��l�j�
D���ӥ���=c-Ŧ�ݾ�����i��S�~��rZ%.U���;F���z�����C�#�.���,�r�5��l�EE�8���^�:����p�!���+]�=&.�p�����u�0=p      V   [   x�3��=��"39�37LZ���(XZ��a�2�t*J,���L��j3�t-.IL�,V��L�/�Lq��K!\b͉���� |�-s      T      x������ � �      Z      x������ � �      p   �  x���]n�8��ݧ��B��r�ARf8v`ǻ��oS�����?*&��TI�>~~����Z]N�$�����o�"��j�������q{d��4A窮��-�5���^�w����T_�+��}<���Q]Z�S�rH#߯фB�#����gS5�(��y�Bh�3�i/-�l��H�	��:��)P�?��r�	3x�!'�F�K�
i$��l��k�F�H��:_�"�ÃF��W&wkGr�L�~ў���$��͒�J��^����Q�p#IFa
B`ǌ"9�$Ei���-����Hq�Ɛ��ҐX��Ƒ�0H�3���$6̔�f��jx�g���"u��^ ʹ�UoET��F��6ԗ��~���c"g���\������u��ء�O�`�접*��p@F.q���V̍倍\4�B��~���a��A�ӃF\��n��'6LtD
`Q���5G(�H/��`7��#�IH�K�Jި,�Ŷ�š
��|	����E�*hd�a&6��ֿ�3���G��F�42�U���Q!��0�Q�	q����̧�v}�~>�U�ݮ/Me��>�%�mYw���T�������{�##�������{�L��{�D�0hd���[ӈ���}����-M��v�EE1hd�xɃ84�_��tǃ8)ґ5�/��b�tIO֝�{�?m\��g�&P��� ���<���%�����}��-���À�$7ܩ�@��J��UGd�Q�Fn�Y�����#Or�
·��6^]`~}v�t�TUs{�W�4k'�|�gR����'�	́�`⦽�]��U0"��%g�ŴA�O��7�����:b�:4��{���Vz�]�[>?֤45�sY�&�ʔ&�)ג�x_?ؓ8 ynxmu���~�M��1I�v)���+O\�AP���rlm�*]���#hT�m���G�GQr���E��l�=DB�J���28���2P���2�r��a
i$�b��b��!N#�9���h�Ơ�d|��HcR�B���R>�:�1kǘ1%Ҙqs�(|���/A��+�I_(�uԇ@�1(�� VA��s؇(`4.8B�%�C�Y�f�^�}9�Y�}��&��?Dy�1��a�_��%�*��3�0Qn2�R��/��/������چ�ͯt��t��z��V5lU��j�X`;ö��w��E��s;����_
ʣ��(������*�E ��a��[�.�́�&��H�ɒ�I��g�1h��}@��}B�`�1l7-�9hL�]F���mH����Ac�ܥ����4K�-��ё��ƴ�d���W"|eU��5��(mE s	6�6۸�Pc���V4.��Y�9����5g�2�\�.��He�h`y���"�ߜE&SW48��Q�k�<z���f�"0�M���0vJ^��>q���+�$8w�ϝ��5�+W�kg����A�|�� |�_5f�.E��	�|B�8����l�)?B��$[h��_��>�E0h�ۀu�����}h�>�́K�f���9����J��,g
���r`��b�Q�G��*���,Jcs&p�8���+>��o������	_lY4t�Jy��ds���*9�چ�9���%���Ĳ�56�q��rYĂj�,��'����]      h   �   x��ӽj1�z�)�Z��u��$�@H\���l���w�=}�i�]��a��G��d4�n�ѓ����U����M �"Z@tEt���11 b,bk�����S{"�>$����&G�8�S��[Y��>�GHC�%,w��t�4��V������_�{��Q����$ڹ �U�_�f@�k��%"��]�y�<��RU�/j!��      `      x������ � �      n   G   x�3�4�Գ4�420��50�54Q02�20�25�&�eQ���F�cN#�U����X�҂h�1z\\\ �+�      l      x������ � �      ~      x������ � �      |      x������ � �      S   ?  x����֢F���=E/z�(�ҫ0��(���ɦ�b(F�,�XЯ��E���:��_�� 4\��-J��$� Ȟv�pˡ���[T�$|���T���~�efwf�����y+vw]�WD�.�LM�-�tgx�~��L.x9�@X��PSr�mJ~#�/�����β?�>� ��58�,i���:� ~z��z�G���ƞ{U ��m�ԶC�A_w���X/��@h����)m����!C),��.��5�p��7�_�*s���a��~%�}���e#.s�HT!:3ü�Cemi��GP�Pn�!��W��n��/�.9��x�fU�r���ǁG�~ZA���"/f�Li�_g�w!'�6��1,z�&9*��@��I?���i�4��,OK��3{3U��\1;���ہ_�;��l,o�R��̭���hq1v�4�[1��O�?�K�+35�k�vT��ֺK;�`�(�Ț����j���9F�y���v@��cQ-\ר[X��#��q�>͗��w�8�(�ҳ��Wq�cK��TjR��:G||���4�Se }���0b�oq�S���I|L܌�� 0���J?�*�c{y9eW��8��;�Ʉ��|S|WxCs�a��KD
�U��}z��J�{�n�8-�h00� �v���W��_�����-�j��6S|��G:?ŕ�mfZqc�8����� ��cR����"K�6�gv�q����~��M�_^	ڑ�z-�9��� ��7n�s{�E�[�#.`}[�{Ħ��?���y$=�}�18������x�6b�Ð%C��lu劝���pl%��k���֝Zw>�ȷ��5�����`���Y��cƆ�r�d����N!�b�)��ğ��jg�t�r�GT��_�T�l�J�֒n�����!S${�;:$cC�c���˴#t���-5l�2T-J��n�ܰ�LX�{�z�ٟ4���;�1�5���WI�+�p��F���Z��b�A���)_�|2+ի�j�����A�GE:��	�`\�p�rs)��oS��c�.��4}�n�x�n��t-:���߉���� �ч�      d   f   x�3�t,.H-J�420��50�54Q02�20�25�&�e��_���X\B�c�p'�W�u��t�x*8�9�ϔL}f�.�>��
��.��k����� J�@'     