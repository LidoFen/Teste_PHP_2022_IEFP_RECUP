-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           10.4.28-MariaDB - mariadb.org binary distribution
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para competicao
CREATE DATABASE IF NOT EXISTS `competicao` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `competicao`;

-- A despejar estrutura para tabela competicao.cluster
CREATE TABLE IF NOT EXISTS `cluster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela competicao.cluster: ~6 rows (aproximadamente)
DELETE FROM `cluster`;
INSERT INTO `cluster` (`id`, `descricao`) VALUES
	(1, 'CLUSTER CONSTRUÇÃO CIVIL E OBRAS PÚBLICAS'),
	(2, 'CLUSTER ARTES CRIATIVAS'),
	(3, 'CLUSTER GESTÃO E TECNOLOGIAS DA INFORMAÇÃO'),
	(4, 'CLUSTER PRODUÇÃO, ENGENHARIA E TECNOLOGIA'),
	(5, 'CLUSTER SERVIÇOS SOCIAIS, PESSOAIS E TURISMO'),
	(6, 'CLUSTER TRANSPORTE E LOGÍSTICA');

-- A despejar estrutura para tabela competicao.concorrente
CREATE TABLE IF NOT EXISTS `concorrente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` text DEFAULT NULL,
  `cartao_cidadao` int(11) DEFAULT NULL,
  `nif` int(11) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `id_tamanho` int(11) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `id_regiao` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tamanho` (`id_tamanho`),
  KEY `id_regiao` (`id_regiao`),
  CONSTRAINT `concorrente_ibfk_1` FOREIGN KEY (`id_tamanho`) REFERENCES `tamanhos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `concorrente_ibfk_2` FOREIGN KEY (`id_regiao`) REFERENCES `regiao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela competicao.concorrente: ~1 rows (aproximadamente)
DELETE FROM `concorrente`;
INSERT INTO `concorrente` (`id`, `nome`, `cartao_cidadao`, `nif`, `email`, `id_tamanho`, `idade`, `id_regiao`, `foto`) VALUES
	(1, 'Pedro Delfino', 14767793, 271018925, 'pedrompd96@gmail.com', 2, 24, 2, 'fotoConcorrente/Pedro Delfino/foto_Pedro Delfino_dataEnv_20230916_16_49_00.jpg'),
	(2, 'André Figo', 1235698, 256487956, 'luis@mail.pt', 3, 23, 3, 'fotoConcorrente/André Figo/foto_André Figo_dataEnv_20230916_17_44_22.jpg');

-- A despejar estrutura para tabela competicao.criterios
CREATE TABLE IF NOT EXISTS `criterios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text DEFAULT NULL,
  `pontuacao_minima` int(11) DEFAULT NULL,
  `pontuacao_maxima` int(11) DEFAULT NULL,
  `id_prova` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_prova` (`id_prova`),
  CONSTRAINT `criterios_ibfk_1` FOREIGN KEY (`id_prova`) REFERENCES `prova` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela competicao.criterios: ~5 rows (aproximadamente)
DELETE FROM `criterios`;
INSERT INTO `criterios` (`id`, `descricao`, `pontuacao_minima`, `pontuacao_maxima`, `id_prova`) VALUES
	(1, 'Requisito nº1', 0, 3, 1),
	(2, 'Requisito nº2', 0, 5, 1),
	(3, 'Requisito nº3', 0, 3, 1),
	(4, 'Requisito nº1', 0, 5, 2),
	(5, 'Requisito nº2', 0, 5, 2);

-- A despejar estrutura para tabela competicao.inscricao
CREATE TABLE IF NOT EXISTS `inscricao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_concorrente` int(11) NOT NULL,
  `id_prova` int(11) NOT NULL,
  `dth` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_concorrente` (`id_concorrente`),
  KEY `id_prova` (`id_prova`),
  CONSTRAINT `inscricao_ibfk_1` FOREIGN KEY (`id_concorrente`) REFERENCES `concorrente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inscricao_ibfk_2` FOREIGN KEY (`id_prova`) REFERENCES `prova` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela competicao.inscricao: ~1 rows (aproximadamente)
DELETE FROM `inscricao`;
INSERT INTO `inscricao` (`id`, `id_concorrente`, `id_prova`, `dth`) VALUES
	(5, 1, 1, '2023-09-16 17:06:09'),
	(6, 2, 2, '2023-09-16 17:06:13');

-- A despejar estrutura para tabela competicao.prova
CREATE TABLE IF NOT EXISTS `prova` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text DEFAULT NULL,
  `id_cluster` int(11) DEFAULT NULL,
  `idade_limite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cluster` (`id_cluster`),
  CONSTRAINT `prova_ibfk_1` FOREIGN KEY (`id_cluster`) REFERENCES `cluster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela competicao.prova: ~1 rows (aproximadamente)
DELETE FROM `prova`;
INSERT INTO `prova` (`id`, `descricao`, `id_cluster`, `idade_limite`) VALUES
	(1, 'Prova de Programação Aplicada', 3, 25),
	(2, 'Prova de Algoritmia', 3, 25);

-- A despejar estrutura para tabela competicao.regiao
CREATE TABLE IF NOT EXISTS `regiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela competicao.regiao: ~5 rows (aproximadamente)
DELETE FROM `regiao`;
INSERT INTO `regiao` (`id`, `descricao`) VALUES
	(1, 'Lisboa e Vale do Tejo'),
	(2, 'Alentejo'),
	(3, 'Algarve'),
	(4, 'Madeira'),
	(5, 'Açores');

-- A despejar estrutura para tabela competicao.resultados
CREATE TABLE IF NOT EXISTS `resultados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_criterio` int(11) NOT NULL,
  `id_inscricao` int(11) NOT NULL,
  `avaliacao` int(11) DEFAULT NULL,
  `dth` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_criterio` (`id_criterio`),
  KEY `id_inscricao` (`id_inscricao`),
  CONSTRAINT `resultados_ibfk_2` FOREIGN KEY (`id_criterio`) REFERENCES `criterios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `resultados_ibfk_3` FOREIGN KEY (`id_inscricao`) REFERENCES `inscricao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela competicao.resultados: ~8 rows (aproximadamente)
DELETE FROM `resultados`;
INSERT INTO `resultados` (`id`, `id_criterio`, `id_inscricao`, `avaliacao`, `dth`) VALUES
	(14, 1, 5, 0, '2023-09-16 17:06:09'),
	(15, 4, 6, 0, '2023-09-16 17:06:13'),
	(16, 1, 5, 2, '2023-09-16 17:06:25'),
	(17, 2, 5, 2, '2023-09-16 17:06:31'),
	(18, 3, 5, 2, '2023-09-16 17:06:36'),
	(19, 4, 6, 2, '2023-09-16 17:06:47'),
	(20, 4, 6, 2, '2023-09-16 17:06:54'),
	(21, 5, 6, 2, '2023-09-16 17:17:45');

-- A despejar estrutura para tabela competicao.tamanhos
CREATE TABLE IF NOT EXISTS `tamanhos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela competicao.tamanhos: ~5 rows (aproximadamente)
DELETE FROM `tamanhos`;
INSERT INTO `tamanhos` (`id`, `descricao`) VALUES
	(1, 'S'),
	(2, 'M'),
	(3, 'L'),
	(4, 'XL'),
	(5, 'XXL');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
