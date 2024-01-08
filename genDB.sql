CREATE TABLE "public"."users" ( 
  "id" SERIAL,
  "email" TEXT NULL,
  "password" TEXT NULL,
  "primeiro_nome" TEXT NULL,
  "ultimo_nome" TEXT NULL,
  "tipo_utilizador" TEXT NULL,
  "imagem_perfil" TEXT NULL,
  "sobre" TEXT NULL,
  "data_registo" TIMESTAMP NULL,
  CONSTRAINT "user_pkey" PRIMARY KEY ("id"),
  CONSTRAINT "users_email_key" UNIQUE ("email")
);
CREATE TABLE "public"."licitacoes" ( 
  "id" SERIAL,
  "user_id" INTEGER NULL,
  "item_id" INTEGER NULL,
  "valor" NUMERIC NULL,
  "data_licitacao" TIMESTAMP NULL,
  CONSTRAINT "licitacoes_pkey" PRIMARY KEY ("id")
);
CREATE TABLE "public"."sugestoes" ( 
  "id" SERIAL,
  "nome" TEXT NULL,
  "email" TEXT NULL,
  "assunto" TEXT NULL,
  "mensagem" TEXT NULL,
  CONSTRAINT "sugestoes_pkey" PRIMARY KEY ("id")
);
CREATE TABLE "public"."imagens" ( 
  "id" SERIAL,
  "item_id" INTEGER NULL,
  "image_number" INTEGER NULL,
  "data" TIMESTAMP NULL,
  CONSTRAINT "imagens_pkey" PRIMARY KEY ("id")
);
CREATE TABLE "public"."ficheiros" ( 
  "id" SERIAL,
  "item_id" INTEGER NULL,
  "files_number" INTEGER NULL,
  "data" TIMESTAMP NULL,
  CONSTRAINT "ficheiros_pkey" PRIMARY KEY ("id")
);
CREATE TABLE "public"."items" ( 
  "id" SERIAL,
  "titulo" TEXT NULL,
  "descricao" TEXT NULL,
  "vendedor_id" INTEGER NOT NULL,
  "primeira_licitacao" NUMERIC NULL,
  "comprar_agora_preco" NUMERIC NULL,
  "data_inicio" TIMESTAMP NULL,
  "data_final" TIMESTAMP NULL,
  "licitacao_corrente" NUMERIC NULL,
  "num_licitacoes" INTEGER NULL,
  "estado" TEXT NULL,
  "categoria" TEXT NULL,
  "data_sub" TIMESTAMP NULL,
  CONSTRAINT "items_pkey" PRIMARY KEY ("id")
);
ALTER TABLE "public"."licitacoes" ADD CONSTRAINT "licitacoes_user_id_fkey" FOREIGN KEY ("user_id") REFERENCES "public"."users" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."licitacoes" ADD CONSTRAINT "licitacoes_item_id_fkey" FOREIGN KEY ("item_id") REFERENCES "public"."items" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."imagens" ADD CONSTRAINT "imagens_item_id_fkey" FOREIGN KEY ("item_id") REFERENCES "public"."items" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."ficheiros" ADD CONSTRAINT "ficheiros_item_id_fkey" FOREIGN KEY ("item_id") REFERENCES "public"."items" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE "public"."items" ADD CONSTRAINT "items_vendedor_id_fkey" FOREIGN KEY ("vendedor_id") REFERENCES "public"."users" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION;
