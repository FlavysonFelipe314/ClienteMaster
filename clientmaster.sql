-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/12/2024 às 23:06
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `clientmaster`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `ranking` int(50) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `id_user`, `name`, `email`, `avatar`, `birthdate`, `ranking`, `created_at`, `updated_at`) VALUES
(9, 10, 'Arnold Litt', 'arnold@gmail.com', 'fb938c3f2fced479dca86442780d8d1b', '2003-11-28', 0, '2024-11-25 03:56:01', '2024-11-27 16:56:31'),
(14, 9, 'Arthur Morgan', 'arteiroM@gmail.com', 'c354f36334983dabae249926816b62d0', '2002-11-12', 0, '2024-11-25 04:47:11', '2024-11-27 19:59:30'),
(20, 10, 'Marcelo Alves', 'bigg.flavy314@gmail.com', '15aa47017d6ec8e69941cf29e1a9870f', '2001-10-13', 1, '2024-11-27 05:00:28', '2024-11-28 04:28:16'),
(21, 10, 'carlos teixeira Macedo', 'flavysonf616@gmail.com', '682ed2ca3c66c587b0e418abff9e7181', '2002-11-27', 0, '2024-11-27 06:06:04', '2024-11-28 12:59:55'),
(22, 9, 'flavyson felipe', 'flavysonFelipe314@gmail.com', 'f4a9d6f396f3ea288d0d570e7ce603fc', '2003-10-13', 1, '2024-11-27 08:16:31', '2024-11-27 12:39:55'),
(24, 9, 'jaedna ', 'jaedna@gmail.com', 'a3f08362ace5edf5399ef8c33e706f75', '2000-02-12', 2, '2024-11-27 08:28:15', '2024-11-27 12:55:30'),
(25, 9, 'teste', 'teste1@gmail.com', '58caceff0202453a23d31e692d9469e0', '2002-11-13', 1, '2024-11-27 11:22:23', '2024-11-27 19:59:05'),
(27, 12, 'teste Cliente', 'flavysonFelipe314@gmail.com', '9ecf2b889536fffcc12fec62c7a34005', '2003-11-13', 1, '2024-11-29 06:06:56', '2024-11-29 06:07:46'),
(28, 14, 'cliente Exemplo', 'flavysonFelipe314@gmail.com', '75f2aea3f7d21f4a8af460e72942ea5a', '2003-11-13', 1, '2024-11-29 06:31:48', '2024-11-29 06:34:04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cupons`
--

CREATE TABLE `cupons` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `total_discount` decimal(10,2) NOT NULL,
  `type_discount` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cupons`
--

INSERT INTO `cupons` (`id`, `id_user`, `id_client`, `name`, `total_discount`, `type_discount`) VALUES
(13, 10, 0, 'CUPOM01', 20.00, '%'),
(15, 9, 0, 'Teste Cupom', 12.00, '%'),
(16, 9, 0, 'teste 9982', 21.00, 'R$'),
(17, 12, 0, 'TESTEC1', 10.00, '%'),
(18, 14, 28, 'CUPOMTESTE', 15.00, 'R$');

-- --------------------------------------------------------

--
-- Estrutura para tabela `systems`
--

CREATE TABLE `systems` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `primary_color` varchar(50) DEFAULT '#01020A',
  `secondary_color` varchar(50) DEFAULT '#E88B16',
  `background_color` varchar(50) DEFAULT '#DDDDDD',
  `logo` varchar(255) DEFAULT 'logo_default.png',
  `business_name` varchar(255) DEFAULT 'Cliente Master',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `systems`
--

INSERT INTO `systems` (`id`, `id_user`, `primary_color`, `secondary_color`, `background_color`, `logo`, `business_name`, `created_at`, `updated_at`) VALUES
(1, 9, '#01020A', '#E88B16', '#DEE0E5', 'logo_default.png', 'Cliente Master', '2024-11-29 04:53:43', '2024-11-29 04:53:43'),
(2, 13, '#000000', '#dbab29', '#ffebf5', 'a7f056a61466d4e7c45adab0b23fba7e.jpg', 'Cliente', '2024-11-29 05:07:46', '2024-11-29 05:47:24'),
(3, 12, '#000000', '#e88b16', '#d1d1d1', 'ec4af738a2a12e76113fec08c07da513.jpg', 'loja do cleitin', '2024-11-29 06:06:34', '2024-11-29 06:16:15'),
(4, 14, '#020203', '#1049bc', '#dddddd', '65194408a62e6e39a4e8fa9edd7a9056.jpg', 'DevMusic', '2024-11-29 06:21:49', '2024-11-29 06:31:06');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `cpf` char(14) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `birthdate`, `cpf`, `token`, `created_at`, `updated_at`) VALUES
(9, 'flavyson filip', 'flavysonf616@gmail.com', '$2y$10$Si77yNH2wAwyPjXgOvma3u/d.D.ois.wGKrrg4P1JJA6kqhPhSxvG', '7b3fc9eac92b0d3e219e3d77eaaad5ee', '2003-10-13', '709.488.144-46', 'c0450b1837b31d05297ca51d5d90207a', '2024-11-25 03:51:27', '2024-11-29 05:59:19'),
(10, 'erick', 'erick@gmail.com', '$2y$10$PtHi/ZqSVjtZ4Fb/0kiYGe406AYbXuMt4rBk4UI.5lkkNnz63D.3K', 'f4f1b52888b52cc36d4e8a3bfecebb97', '2000-02-12', '234.242.342-34', '2e6ddc7d2221312e95c71702b2c27435', '2024-11-25 03:54:31', '2024-11-28 12:51:39'),
(11, 'novo', 'novo@gmail.com', '$2y$10$br/zfokIz6NR8iQ8qJBFae6GO5AOyFbrZ4kecsqIcONnrxh4XWYEe', 'default_avatar.png', '2000-02-12', '123.123.1231-2', '4ad4c48ab9a6874fc5c197399b890691', '2024-11-27 02:35:20', '2024-11-27 02:35:20'),
(12, 'Cleiton Magalh&atilde;es', 'testeCli@gmail.com', '$2y$10$lwzf/9pFfYXa6HpiILrwreAQter3ZEFTOkKx/4ZkowmZxTwUJE73q', '4bfe2decd272bc46e30a3f21e2bc963f', '2000-10-12', '123.123.123-34', '2726559bb52f05aeb9561d153bc269f1', '2024-11-29 05:02:58', '2024-11-29 06:18:18'),
(13, 'testeCli2', 'testeCli2@gmail.com', '$2y$10$6TRE9BUzRERqG4D2cpjFQeMdEx1QbRV7OMll1pKaNu8cI2Odz1osi', 'default_avatar.png', '2000-10-23', '798.343.223-32', 'f1c1aa8ec37d7ecb0949dd2814d043f9', '2024-11-29 05:07:46', '2024-11-29 05:07:46'),
(14, 'cliente Apresenta&ccedil;&atilde;o', 'clienteapresentacao@gmail.com', '$2y$10$xGx/wfLaFrydhu8hsOqW8eg0GAg2AroxdfY2H5nTFqUui4vyP5RS6', 'default_avatar.png', '2003-10-13', '123.123.123-45', 'e0d6068cd79d73fbd897f580f45f7f0a', '2024-11-29 06:21:49', '2024-11-29 06:30:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_cupom` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `service` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id`, `id_user`, `id_cliente`, `id_cupom`, `total`, `service`) VALUES
(1, 10, 9, 0, 123.00, 'pagou com pix, barba'),
(3, 10, 9, 0, 12.00, '123'),
(4, 10, 20, 0, 12.00, 'sdfsdf fdsd fsf'),
(5, 10, 20, 0, 210.00, 'SVZFSFDGSD'),
(23, 9, 22, 0, 150.00, 'Barba, Cabelo e Bigode! Pagamento Pix'),
(24, 9, 24, 0, 175.00, 'asdaDasdASD'),
(25, 9, 24, 0, 10.00, '23487'),
(26, 9, 25, 0, 12.50, 'asdfas'),
(27, 10, 20, 0, 12.00, 'qoweuiodasf sadf'),
(28, 12, 27, 0, 100.50, 'fez, barba, cabelo e bigode'),
(29, 14, 28, 18, 150.00, 'teste ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `visitas`
--

CREATE TABLE `visitas` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `data_visita` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `visitas`
--

INSERT INTO `visitas` (`id`, `id_user`, `id_cliente`, `data_visita`, `description`) VALUES
(3, 10, 9, '13 de outubro', 'barba'),
(5, 10, 9, '13/10/2003', 'asdfasdfafdf');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`id_user`);

--
-- Índices de tabela `cupons`
--
ALTER TABLE `cupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_cliente` (`id_client`);

--
-- Índices de tabela `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`id_user`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_cliente` (`id_cliente`);

--
-- Índices de tabela `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`id_user`),
  ADD KEY `idx_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `cupons`
--
ALTER TABLE `cupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `systems`
--
ALTER TABLE `systems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `cupons`
--
ALTER TABLE `cupons`
  ADD CONSTRAINT `cupons_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `systems`
--
ALTER TABLE `systems`
  ADD CONSTRAINT `systems_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_vendas_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `visitas`
--
ALTER TABLE `visitas`
  ADD CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visitas_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
