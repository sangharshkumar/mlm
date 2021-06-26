-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 10, 2021 at 09:18 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mlm`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `wallet` decimal(10,2) NOT NULL,
  `income` decimal(10,2) NOT NULL,
  `total_income` decimal(10,2) NOT NULL,
  `total_withdrawl` decimal(10,2) NOT NULL,
  `expenditure` decimal(10,2) NOT NULL,
  `pending` decimal(10,2) NOT NULL,
  `last_added_money` decimal(10,2) NOT NULL,
  `total_added_money` decimal(10,2) NOT NULL,
  `last_withdrawl` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`id`, `user_id`, `wallet`, `income`, `total_income`, `total_withdrawl`, `expenditure`, `pending`, `last_added_money`, `total_added_money`, `last_withdrawl`) VALUES
(1, '1006090', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `blocked_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `capping`
--

CREATE TABLE `capping` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `income` decimal(10,2) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_summary`
--

CREATE TABLE `deposit_summary` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `level_income`
--

CREATE TABLE `level_income` (
  `id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` decimal(65,2) NOT NULL,
  `level` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login_session`
--

CREATE TABLE `login_session` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `loggedin_at` varchar(255) NOT NULL,
  `valid_till` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_session`
--

INSERT INTO `login_session` (`id`, `user_id`, `session_id`, `loggedin_at`, `valid_till`) VALUES
(1, '1006090', '96c389e44b834d95bb17682f30ab089e', '1618039057', '1620631057');

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `otp_id` int(11) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `otp_email` varchar(255) NOT NULL,
  `otp_inserted_date` varchar(255) NOT NULL,
  `otp_valid_date` varchar(255) NOT NULL,
  `otp_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pair_count`
--

CREATE TABLE `pair_count` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `pair_count` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment_session`
--

CREATE TABLE `payment_session` (
  `payment_id` int(255) NOT NULL,
  `payer_user_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `payable_amount` varchar(255) NOT NULL,
  `paid_amount` varchar(255) NOT NULL,
  `payment_date` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pins`
--

CREATE TABLE `pins` (
  `pin_id` int(255) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `pin_creator` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `activation_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pin_transfer_history`
--

CREATE TABLE `pin_transfer_history` (
  `serial_number` int(255) NOT NULL,
  `pin_creator` varchar(255) NOT NULL,
  `pin_count` varchar(255) NOT NULL,
  `expenditue` decimal(10,2) NOT NULL,
  `date_created` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `referral_income`
--

CREATE TABLE `referral_income` (
  `id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` decimal(65,2) NOT NULL,
  `agent_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(255) NOT NULL,
  `ticket_id` varchar(255) NOT NULL,
  `ticket_creator` varchar(255) NOT NULL,
  `ticket_subject` varchar(255) NOT NULL,
  `ticket_create_date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `ticket_closed_by` varchar(255) NOT NULL,
  `ticket_close_date` varchar(255) NOT NULL,
  `last_reply_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` int(255) NOT NULL,
  `ticket_id` varchar(255) NOT NULL,
  `ticket_creator` varchar(255) NOT NULL,
  `ticket_message` varchar(2000) NOT NULL,
  `ticket_date` varchar(255) NOT NULL,
  `ticket_files` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` int(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_creator` varchar(255) NOT NULL,
  `token_inserted_date` varchar(255) NOT NULL,
  `token_valid_date` varchar(255) NOT NULL,
  `token_purpose` varchar(255) NOT NULL,
  `token_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `transaction_id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_charge` decimal(10,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `category` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tree`
--

CREATE TABLE `tree` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `referral_id` varchar(255) NOT NULL,
  `placement_id` varchar(255) NOT NULL,
  `placement_type` varchar(255) NOT NULL,
  `left_count` int(255) NOT NULL,
  `right_count` int(255) NOT NULL,
  `left_id` bigint(255) NOT NULL,
  `right_id` bigint(255) NOT NULL,
  `pair_count` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tree`
--

INSERT INTO `tree` (`id`, `user_id`, `referral_id`, `placement_id`, `placement_type`, `left_count`, `right_count`, `left_id`, `right_id`, `pair_count`) VALUES
(1, '1006090', '0', '0', 'left', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_pincode` varchar(255) NOT NULL,
  `user_contact_email` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `account_image` varchar(255) NOT NULL,
  `user_registration_date` varchar(255) NOT NULL,
  `user_account_number` varchar(255) NOT NULL,
  `user_upi` varchar(255) NOT NULL,
  `referal_code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `user_password`, `first_name`, `last_name`, `user_phone`, `user_address`, `user_pincode`, `user_contact_email`, `user_image`, `account_image`, `user_registration_date`, `user_account_number`, `user_upi`, `referal_code`, `status`) VALUES
(1, '1006090', 'admin', '$2y$10$GZY1UH.PbMzz0yGv3vX5V.MQJuJxHHPsPy1W.ABqnq4CwV9vbDg.q', 'Admin', 'Kumar', '+911234567890', 'Sasaram', '821115', 'princeraj9137@gmail.com', '0324202113315136a72b63-a526-45ec-8b83-a20d87baa240avatar.jpg', '', '1617786872', '564261 256786  72897 912', 'GHEY73637', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_logs`
--

CREATE TABLE `wallet_logs` (
  `id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `wallet` decimal(50,2) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_request`
--

CREATE TABLE `withdraw_request` (
  `withdraw_id` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `charge` decimal(10,2) NOT NULL,
  `other_charge` decimal(10,2) NOT NULL,
  `payable` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `requested_date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `payment_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `capping`
--
ALTER TABLE `capping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_summary`
--
ALTER TABLE `deposit_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_income`
--
ALTER TABLE `level_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_session`
--
ALTER TABLE `login_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`otp_id`);

--
-- Indexes for table `pair_count`
--
ALTER TABLE `pair_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_session`
--
ALTER TABLE `payment_session`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `pins`
--
ALTER TABLE `pins`
  ADD PRIMARY KEY (`pin_id`);

--
-- Indexes for table `pin_transfer_history`
--
ALTER TABLE `pin_transfer_history`
  ADD PRIMARY KEY (`serial_number`);

--
-- Indexes for table `referral_income`
--
ALTER TABLE `referral_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `tree`
--
ALTER TABLE `tree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_logs`
--
ALTER TABLE `wallet_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_request`
--
ALTER TABLE `withdraw_request`
  ADD PRIMARY KEY (`withdraw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `capping`
--
ALTER TABLE `capping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit_summary`
--
ALTER TABLE `deposit_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level_income`
--
ALTER TABLE `level_income`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_session`
--
ALTER TABLE `login_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pair_count`
--
ALTER TABLE `pair_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_session`
--
ALTER TABLE `payment_session`
  MODIFY `payment_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pins`
--
ALTER TABLE `pins`
  MODIFY `pin_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pin_transfer_history`
--
ALTER TABLE `pin_transfer_history`
  MODIFY `serial_number` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referral_income`
--
ALTER TABLE `referral_income`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tree`
--
ALTER TABLE `tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wallet_logs`
--
ALTER TABLE `wallet_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_request`
--
ALTER TABLE `withdraw_request`
  MODIFY `withdraw_id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
