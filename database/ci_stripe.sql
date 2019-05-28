-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2019 at 03:48 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_stripe`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL COMMENT 'unique id',
  `response` text NOT NULL COMMENT 'response from stripe',
  `status` int(11) NOT NULL COMMENT '1 = Success, 0 = Fail',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `response`, `status`, `created_at`) VALUES
(1, '{\"id\":\"ch_1EeuNnBx71XwPn0QKVEfkiLt\",\"object\":\"charge\",\"amount\":10000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_1EeuNoBx71XwPn0QXXY2Iy9m\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":null,\"state\":null},\"email\":null,\"name\":\"August Wiggins\",\"phone\":null},\"captured\":true,\"created\":1559007943,\"currency\":\"gbp\",\"customer\":null,\"description\":\"TEST PAYMENT\",\"destination\":null,\"dispute\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":{\"order_id\":\"20190528034541-954\"},\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":23,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1EeuNmBx71XwPn0QWdpyyZ7o\",\"payment_method_details\":{\"card\":{\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":null,\"cvc_check\":\"pass\"},\"country\":\"US\",\"description\":\"Visa Classic\",\"exp_month\":12,\"exp_year\":2020,\"fingerprint\":\"IIOX8H95BaAsAfiF\",\"funding\":\"credit\",\"last4\":\"4242\",\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/acct_1EZalpBx71XwPn0Q\\/ch_1EeuNnBx71XwPn0QKVEfkiLt\\/rcpt_F9Cn59G6UlVDArAxz0FK28pW4YDRpZz\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_1EeuNnBx71XwPn0QKVEfkiLt\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1EeuNmBx71XwPn0QWdpyyZ7o\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":null,\"address_zip_check\":null,\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2020,\"fingerprint\":\"IIOX8H95BaAsAfiF\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":\"August Wiggins\",\"tokenization_method\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', 1, '2019-05-28 01:45:43'),
(2, '{\"id\":\"ch_1EeuO0Bx71XwPn0QiJzi6Kyo\",\"object\":\"charge\",\"amount\":10000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_1EeuO0Bx71XwPn0Qcspjb0RV\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":null,\"state\":null},\"email\":null,\"name\":\"August Wiggins\",\"phone\":null},\"captured\":true,\"created\":1559007956,\"currency\":\"gbp\",\"customer\":null,\"description\":\"TEST PAYMENT\",\"destination\":null,\"dispute\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":{\"order_id\":\"20190528034554-799\"},\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":12,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1EeuNzBx71XwPn0QKmKk2SrA\",\"payment_method_details\":{\"card\":{\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":null,\"cvc_check\":\"pass\"},\"country\":\"US\",\"description\":\"Visa Classic\",\"exp_month\":12,\"exp_year\":2020,\"fingerprint\":\"IIOX8H95BaAsAfiF\",\"funding\":\"credit\",\"last4\":\"4242\",\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/acct_1EZalpBx71XwPn0Q\\/ch_1EeuO0Bx71XwPn0QiJzi6Kyo\\/rcpt_F9CnvrDMUjeO4J0AIckH5nC5TV7fW9W\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_1EeuO0Bx71XwPn0QiJzi6Kyo\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1EeuNzBx71XwPn0QKmKk2SrA\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":null,\"address_zip_check\":null,\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2020,\"fingerprint\":\"IIOX8H95BaAsAfiF\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":\"August Wiggins\",\"tokenization_method\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', 1, '2019-05-28 01:45:55'),
(3, '{\"id\":\"ch_1EeuOiBx71XwPn0Q5R2u4DYz\",\"object\":\"charge\",\"amount\":10000,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_1EeuOjBx71XwPn0QIYsTkQcP\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":null,\"state\":null},\"email\":null,\"name\":\"August Wiggins\",\"phone\":null},\"captured\":true,\"created\":1559008000,\"currency\":\"gbp\",\"customer\":null,\"description\":\"TEST PAYMENT\",\"destination\":null,\"dispute\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":{\"order_id\":\"20190528034638-524\"},\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":17,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1EeuOhBx71XwPn0QHSgQF7gw\",\"payment_method_details\":{\"card\":{\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":null,\"cvc_check\":\"pass\"},\"country\":\"US\",\"description\":\"Visa Classic\",\"exp_month\":12,\"exp_year\":2020,\"fingerprint\":\"IIOX8H95BaAsAfiF\",\"funding\":\"credit\",\"last4\":\"4242\",\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":null,\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/acct_1EZalpBx71XwPn0Q\\/ch_1EeuOiBx71XwPn0Q5R2u4DYz\\/rcpt_F9Co9brdHJNAtH4WP6vTCtxb8gypOAZ\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_1EeuOiBx71XwPn0Q5R2u4DYz\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1EeuOhBx71XwPn0QHSgQF7gw\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":null,\"address_zip_check\":null,\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2020,\"fingerprint\":\"IIOX8H95BaAsAfiF\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":\"August Wiggins\",\"tokenization_method\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', 1, '2019-05-28 01:46:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
