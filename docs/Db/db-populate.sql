-- Nome do banco de dados de trabalho
use phpskel;

-- Criando usuário para acesso a este banco
grant all privileges on phpskel.* to skeluser@'localhost' identified by 'phpskel';
grant all privileges on phpskel.* to skeluser@'%'         identified by 'phpskel';
flush privileges;
-- Criando usuário para acesso a este banco

-- Desativando integridade referencial
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
-- Desativando integridade referencial

-- Limpando as tabelas
truncate app;
truncate db;
-- Limpando as tabelas

-- Inserindo dados sobre a aplicação
INSERT INTO app(`name`, `version`) VALUES 
    ('phpskel', '1.0.0-alpha');
-- Inserindo dados sobre a aplicação

-- Inserindo dados sobre o banco de dados
INSERT INTO db(`version`) VALUES 
    ('1.0.0-alpha');
-- Inserindo dados sobre o banco de dados

-- Reativando integridade referencial
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
-- Reativando integridade referencial