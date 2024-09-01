-- VERSION SANS COMMENTAIRE A LA FIN POUR IMPORTER FACILEMENT DANS phpmyadmin !
--Toutes les tables commencent par 'grL_' pour groupe L sur connected
--La table Chat et Commande sont documentés pour comprendre l'utilité et la structure
CREATE DATABASE IF NOT EXISTS `grL_Chatterie`;
USE `grL_Chatterie`;

--table des admins pour qu'ils puissent se connecter pour gérer la db
create table if not exists `grL_Admin`(
  `id` smallint unsigned not null auto_increment,
  `full_name` varchar(100) not null,
  `username` varchar(50) not null,
  `password` varchar(255) not null,

  primary key(`id`)
) engine = innodb;


--table des catégories pour trier les chats (nos males, nos femelles, les chatons)
create table if not exists `grL_Categorie`(
  `id` smallint unsigned not null auto_increment,
  `nom` varchar(50) not null,
  `nom_image` varchar(255) not null,
  `featured` boolean not null,
  `active` boolean not null,

  primary key(`id`)
) engine = innodb;


--table des chats avec leurs informations et leur gestion sur le site
create table if not exists `grL_Chat`(
  `id` int unsigned not null auto_increment, --Même si le nom aurait pu suffir en logique pour la chatterie, 
  `nom` varchar(50) not null,                --  un adoptant risque de reprendre un nom déjà pris avant
  `description` text not null,        --Pour la couleur, les titres(, le comportement)
  `dateNaissance` date not null,      --Juste un format date, pas besoin de l'heure
  `prix` smallint unsigned,           --Prix possiblement nul si pas à vendre
  `nom_image` varchar(255) not null,
  `categorie_id` smallint unsigned not null, --clé étrangère pour le tri par catégorie
  `status` enum('disponible', 'réservé', 'adopté', 'reproduction') default 'disponible',
  `featured` boolean not null,        --mis en avant sur la page principale
  `active` boolean not null,          --visibilité sur le site (mais toujours chez l'admin)

  primary key(`id`),
  foreign key (`categorie_id`) references `grL_Categorie`(`id`)
) engine = innodb;


--table des commandes pour réserver un chat et avoir les infos client
create table if not exists `grL_Commande`(
  `id` int unsigned not null auto_increment,
  `chat_id` int unsigned not null,    --le chat de la réservation, un seul chat à la fois
  `description` text not null,
  `dateCommande` datetime not null,   --Ici, datetime important s'il y a 2 commandes le même jour pour le même
  `status` enum('commandé', 'réservé', 'adopté', 'annulé') default 'commandé',
  `nom_client` varchar(150) not null, --le nom et prénom du client
  `tel_client` varchar(20) not null,  --le numéro de téléphone du client
  `mail_client` varchar(150) not null,--l'adresse email du client
  `message_client` text,              --si jamais l'acheteur veut laisser des indications sur sa commande
  `notification` boolean              --notification si l'utilisateur coche la case, pas obligatoire

  primary key(`id`),
  foreign key (`chat_id`) references `grL_Chat`(`id`)
) engine = innodb;


--insert pour assurer les logins basiques
INSERT INTO `grL_Admin` (`id`, `full_name`, `username`, `password`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'test Suppr', 'testS', '1ff1de774005f8da13f42943881c655f'),
(3, 'test Update', 'testU', '1ff1de774005f8da13f42943881c655f');

--insert avec les données OK pour gérer le site, toujours modifiable
INSERT INTO `grL_Categorie` (`id`, `nom`, `nom_image`, `featured`, `active`) VALUES
(1, 'Nos Mâles', 'males-002.jpg', 1, 1),
(2, 'Nos Femelles', 'femelles-002.jpg', 1, 1),
(3, 'Nos Chatons', 'chattons-002.jpg', 1, 1),
(4, 'Nos Adoptés', 'adopte-002.jpg', 0, 1);

INSERT INTO `grL_Chat` (`id`, `nom`, `description`, `dateNaissance`, `prix`, `nom_image`, `categorie_id`, `status`, `featured`, `active`) VALUES
(1, 'Tanos', 'Red silver blotched tabby', '2024-08-31', 0, 'Tanos-004.jpg', 1, 'reproduction', 0, 1),
(2, 'Qathena', 'Black brown tortie et white', '2024-08-31', 0, 'Qathena-003.jpg', 2, 'reproduction', 1, 1),
(3, 'Shaky', 'Blue blotched tabby', '2024-08-31', 0, 'Shaky-001.jpg', 1, 'reproduction', 1, 1),
(4, 'Usagy', 'Black silver mackerel tabby', '2024-08-31', 0, 'Usagi-002.jpg', 2, 'reproduction', 1, 1),
(5, 'Zstar', 'Brown blotched tabby', '2024-08-31', 1400, 'Zstar2-005.jpg', 3, 'disponible', 1, 1),
(6, 'Victoire', 'Black blotched brown', '2024-08-31', 1200, 'Victoire2_1725107990.jpg', 3, 'adopté', 1, 1),
(7, 'Yumi', 'Black smoke', '2024-08-31', 1200, 'Yumi2-007.jpg', 3, 'disponible', 1, 1),
(8, 'Zaphira', 'Black smoke', '2024-08-31', 1100, 'Zaphira2-008.jpg', 3, 'disponible', 1, 1),
(9, 'Utopia', 'Black tortie blotched', '2024-08-31', 0, 'Utopia-009.jpg', 4, 'adopté', 0, 1);

INSERT INTO `grL_Commande` (`id`, `chat_id`, `description`, `dateCommande`, `status`, `nom_client`, `tel_client`, `mail_client`, `message_client`, `notification`) VALUES
(1, 8, 'Black smoke', '2024-08-30 05:39:08', 'réservé', 'Matis Bak', '048751524', 'plop@mailinator.com', 'Tournai', 0);











-- VERSION SANS COMMENTAIRE -- -- -- -- -- 


CREATE DATABASE IF NOT EXISTS `grL_Chatterie2`;
USE `grL_Chatterie2`;

create table if not exists `grL_Admin`(
  `id` smallint unsigned not null auto_increment,
  `full_name` varchar(100) not null,
  `username` varchar(50) not null,
  `password` varchar(255) not null,

  primary key(`id`)
) engine = innodb;

create table if not exists `grL_Categorie`(
  `id` smallint unsigned not null auto_increment,
  `nom` varchar(50) not null,
  `nom_image` varchar(255) not null,
  `featured` boolean not null,
  `active` boolean not null,

  primary key(`id`)
) engine = innodb;

create table if not exists `grL_Chat`(
  `id` int unsigned not null auto_increment,
  `nom` varchar(50) not null,
  `description` text not null,
  `dateNaissance` date not null,
  `prix` smallint unsigned,
  `nom_image` varchar(255) not null,
  `categorie_id` smallint unsigned not null,
  `status` enum('disponible', 'réservé', 'adopté', 'reproduction') default 'disponible',
  `featured` boolean not null,
  `active` boolean not null,

  primary key(`id`),
  foreign key (`categorie_id`) references `grL_Categorie`(`id`)
) engine = innodb;

create table if not exists `grL_Commande`(
  `id` int unsigned not null auto_increment,
  `chat_id` int unsigned not null,
  `description` text not null,
  `dateCommande` datetime not null,
  `status` enum('commandé', 'réservé', 'adopté', 'annulé') default 'commandé',
  `nom_client` varchar(150) not null,
  `tel_client` varchar(20) not null,
  `mail_client` varchar(150) not null,
  `message_client` text,
  `notification` boolean,

  primary key(`id`),
  foreign key (`chat_id`) references `grL_Chat`(`id`)
) engine = innodb;

INSERT INTO `grL_Admin` (`id`, `full_name`, `username`, `password`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'test Suppr', 'testS', '1ff1de774005f8da13f42943881c655f'),
(3, 'test Update', 'testU', '1ff1de774005f8da13f42943881c655f');

INSERT INTO `grL_Categorie` (`id`, `nom`, `nom_image`, `featured`, `active`) VALUES
(1, 'Nos Mâles', 'males-002.jpg', 1, 1),
(2, 'Nos Femelles', 'femelles-002.jpg', 1, 1),
(3, 'Nos Chatons', 'chattons-002.jpg', 1, 1),
(4, 'Nos Adoptés', 'adopte-002.jpg', 0, 1);

INSERT INTO `grL_Chat` (`id`, `nom`, `description`, `dateNaissance`, `prix`, `nom_image`, `categorie_id`, `status`, `featured`, `active`) VALUES
(1, 'Tanos', 'Red silver blotched tabby', '2024-08-31', 0, 'Tanos-004.jpg', 1, 'reproduction', 0, 1),
(2, 'Qathena', 'Black brown tortie et white', '2024-08-31', 0, 'Qathena-003.jpg', 2, 'reproduction', 1, 1),
(3, 'Shaky', 'Blue blotched tabby', '2024-08-31', 0, 'Shaky-001.jpg', 1, 'reproduction', 1, 1),
(4, 'Usagy', 'Black silver mackerel tabby', '2024-08-31', 0, 'Usagi-002.jpg', 2, 'reproduction', 1, 1),
(5, 'Zstar', 'Brown blotched tabby', '2024-08-31', 1400, 'Zstar2-005.jpg', 3, 'disponible', 1, 1),
(6, 'Victoire', 'Black blotched brown', '2024-08-31', 1200, 'Victoire2_1725107990.jpg', 3, 'adopté', 1, 1),
(7, 'Yumi', 'Black smoke', '2024-08-31', 1200, 'Yumi2-007.jpg', 3, 'disponible', 1, 1),
(8, 'Zaphira', 'Black smoke', '2024-08-31', 1100, 'Zaphira2-008.jpg', 3, 'disponible', 1, 1),
(9, 'Utopia', 'Black tortie blotched', '2024-08-31', 0, 'Utopia-009.jpg', 4, 'adopté', 0, 1);

INSERT INTO `grL_Commande` (`id`, `chat_id`, `description`, `dateCommande`, `status`, `nom_client`, `tel_client`, `mail_client`, `message_client`, `notification`) VALUES
(1, 8, 'Black smoke', '2024-08-30 05:39:08', 'réservé', 'Matis Bak', '048751524', 'plop@mailinator.com', 'Tournai', 0);
