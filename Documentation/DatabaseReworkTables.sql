-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2020 at 07:06 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectsv2`
--

--
-- Dumping data for table `f20_app_details_table`
--

INSERT INTO `f20_app_details_table` (`AID`, `SID`, `step_order`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 5),
(1, 6, 6),
(1, 7, 7),
(2, 8, 1),
(2, 9, 2),
(2, 10, 3),
(2, 11, 4),
(2, 12, 5);

--
-- Dumping data for table `f20_app_status_table`
--

INSERT INTO `f20_app_status_table` (`ASID`, `title`, `info`) VALUES
(1, 'Done', 'Application that has all of its steps done or approved.'),
(2, 'In-Progress', 'Application that has at least one step unfinished or not approved.'),
(3, 'Deleted', 'Application that is no longer publicly visible.');

--
-- Dumping data for table `f20_app_table`
--

INSERT INTO `f20_app_table` (`AID`, `ASID`, `ATID`, `UID`, `title`, `instructions`, `deadline`, `created`) VALUES
(1, 1, 2, 2, 'Fieldwork', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-10 21:45:59', '2020-11-08 21:45:59'),
(2, 2, 1, 1, 'Independent Study', 'Secretary=>Student=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51');

--
-- Dumping data for table `f20_app_template_details_table`
--

INSERT INTO `f20_app_template_details_table` (`ATPID`, `STPID`, `step_order`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 5),
(1, 6, 6),
(1, 7, 7),
(2, 1, 1),
(2, 2, 2),
(2, 8, 3),
(2, 6, 4),
(2, 7, 5);

--
-- Dumping data for table `f20_app_template_table`
--

INSERT INTO `f20_app_template_table` (`ATPID`, `TSID`, `title`, `instructions`) VALUES
(1, 1, 'Fieldwork', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean'),
(2, 1, 'Independent Study', 'Secretary=>Student=>Faculty=>Chair=>Dean');

--
-- Dumping data for table `f20_app_type_table`
--

INSERT INTO `f20_app_type_table` (`ATID`, `title`, `info`) VALUES
(1, 'Urgent', 'Workflow with high priority which should be taken care of first.'),
(2, 'Normal', 'Workflow with normal priority.');

--
-- Dumping data for table `f20_datastatus_t`
--

INSERT INTO `f20_datastatus_t` (`dataStatus_id`, `dataStatus_title`, `dataStatus_info`) VALUES
('0***', 'Terminated', 'for data which was created but no longer available (deleted) in the system'),
('1***', 'Alive', 'for data which was created and available in the system'),
('1**0', 'Passive', 'for data which is not visible in the system'),
('1**1', 'Active', 'for data which is visible in the system'),
('1*0*', 'Locked', 'not available for others to use besides the user who is currently using it or last modified it'),
('1*1*', 'Released/Unlocked', 'for data which is available to be used in the system'),
('10**', 'Unapproved', 'for data which was created but not approved yet'),
('11**', 'Approved', 'for data which is approved/unlocked and is ready to be used in the system');

--
-- Dumping data for table `f20_datatype_t`
--

INSERT INTO `f20_datatype_t` (`dataType_id`, `dataType_title`, `dataType_info`) VALUES
(1, 'Any', 'Any data item'),
(2, 'Self', 'Data item created/owned by the same user'),
(3, 'Other', 'Data item created by other users'),
(4, 'Form', 'A web form to be filled in'),
(5, 'File', 'A file attached to a task or owned by a user'),
(6, 'Database', 'Field, tables, in a database'),
(7, 'MessageSender', 'Where IN messages are accepted');

--
-- Dumping data for table `f20_data_t`
--

INSERT INTO `f20_data_t` (`data_id`, `dataStatus_id`, `data_location`, `dataType_id`, `data_modifier`, `data_changed`, `data_owner`, `data_created`) VALUES
(1, 1111, 'user|user_info', 6, 1, '2025-01-19 05:10:28', 1, '2020-11-04 18:56:20'),
(104, 1111, '/upload/file1.txt', 5, 2, '2035-01-19 09:13:07', 2, '2020-11-04 18:56:20'),
(105, 1111, '/form/form1.json', 4, 3, '2025-01-19 05:10:28', 3, '2020-11-04 18:56:20');

--
-- Dumping data for table `f20_messagestatus_t`
--

INSERT INTO `f20_messagestatus_t` (`messageStatus_id`, `messageStatus_title`, `messageStatus_info`) VALUES
(1, 'new', 'New unread message'),
(3, 'read', 'Message that has been read'),
(5, 'deleted', 'Not visible');

--
-- Dumping data for table `f20_messagetype_t`
--

INSERT INTO `f20_messagetype_t` (`messageType_id`, `messageType_Title`, `messageType_info`) VALUES
(1, 'urgent', 'Message that needs alert'),
(4, 'normal', 'No message alert ');

--
-- Dumping data for table `f20_message_t`
--

INSERT INTO `f20_message_t` (`message_id`, `message_type`, `message_status`, `task_id`, `message_sender`, `message_receiver`, `message_subject`, `message_contents`, `message_datalink`, `message_created`) VALUES
(1, 2, 2, 1, 2, 4, 'hi', 'Meeting @ 10am Monday', NULL, '2020-11-01 20:07:03'),
(3, 1, 2, 2, 7, 3, 'start', 'Can you review this form?', 105, '2020-11-01 20:08:14'),
(4, 2, 1, 1, 4, 2, 'RE: hi', 'ok', NULL, '2020-11-01 20:09:27'),
(5, 1, 1, 2, 3, 7, 'RE: start', 'Done, approved', 105, '2020-11-01 20:10:24');

--
-- Dumping data for table `f20_step_details_table`
--

INSERT INTO `f20_step_details_table` (`SID`, `UID`, `DID`, `status`) VALUES
(1, 2, NULL, 1),
(2, 3, NULL, 1),
(3, 4, NULL, 1),
(4, 5, NULL, 1),
(5, 6, NULL, 1),
(6, 7, NULL, 1),
(7, 8, NULL, 1),
(8, 2, NULL, 1),
(9, 3, NULL, 1),
(10, 4, NULL, 2),
(11, 5, NULL, 2),
(12, 6, NULL, 2);

--
-- Dumping data for table `f20_step_status_table`
--

INSERT INTO `f20_step_status_table` (`SSID`, `title`, `info`) VALUES
(1, 'Approved', 'Step has been completed and can no longer be modified.'),
(2, 'In-Progress', 'At least one user is still working on the step.'),
(3, 'Rejected', 'At least one user has rejected the step.'),
(4, 'Deleted', 'No longer visible to the users.');

--
-- Dumping data for table `f20_step_table`
--

INSERT INTO `f20_step_table` (`SID`, `SSID`, `STID`, `UID`, `title`, `instructions`, `location`, `deadline`, `created`) VALUES
(1, 1, 1, 2, 'Secretary Form', '[participating users = secretary] secretary fill-in form f1 to create/generate an app(enter student email, select Course, Faculty, Chair, Dean), the system automatically generates an urgent message from Secretary to the primary user of the NEXT step (Student) and also  emails student login info', '/steps/0000000001.php', '2020-11-20 21:45:59', '2020-11-10 21:47:51'),
(2, 1, 1, 2, 'Student Form', '[participating users = student] Student fill-in the (fieldwork) form f2 including Supervisor info, the system automatically generates an urgent message from Student to the primary user of the NEXT step (Faculty) and also emails faculty login info', '/steps/0000000002.php', NULL, NULL),
(3, 1, 1, 2, 'Faculty 1 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also emails Supervisor login info.', '/steps/0000000003.php', NULL, NULL),
(4, 1, 1, 2, 'Supervisor Form', '[participating users = supervisor] Supervisor fill-in the form f4 to edit/approve LO, the system automatically generates a message from Supervisor to Faculty', '/steps/0000000004.php', NULL, NULL),
(5, 1, 1, 2, 'Faculty 2 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also  emails Supervisor login info.', '/steps/0000000005.php', NULL, NULL),
(6, 1, 1, 2, 'Chair Form', '[participating users = Chair] Chair fill-in the form f5 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/steps/0000000006.php', NULL, NULL),
(7, 1, 1, 2, 'Dean Form', '[participating users = Dean] Dean fill-in the form f6 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/steps/0000000007.php', NULL, NULL),
(8, 1, 2, 3, 'Secretary Form', '[participating users = secretary] secretary fill-in form f1 to create/generate an app(enter student email, select Course, Faculty, Chair, Dean), the system automatically generates an urgent message from Secretary to the primary user of the NEXT step (Student) and also  emails student login info', '/steps/0000000008.php', '2020-11-20 21:45:59', '2020-11-10 21:47:51'),
(9, 1, 2, 3, 'Student Form', '[participating users = student] Student fill-in the (fieldwork) form f2 including Supervisor info, the system automatically generates an urgent message from Student to the primary user of the NEXT step (Faculty) and also emails faculty login info', '/steps/0000000009.php', NULL, NULL),
(10, 1, 2, 3, 'Faculty 1 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also emails Supervisor login info.', '/steps/0000000010.php', NULL, NULL),
(11, 1, 2, 3, 'Chair Form', '[participating users = Chair] Chair fill-in the form f5 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/steps/0000000011.php', NULL, NULL),
(12, 1, 2, 3, 'Dean Form', '[participating users = Dean] Dean fill-in the form f6 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/steps/0000000012.php', NULL, NULL);

--
-- Dumping data for table `f20_step_template_details_table`
--

INSERT INTO `f20_step_template_details_table` (`STPID`, `URID`, `DTID`) VALUES
(1, 8, 4),
(2, 9, 4),
(3, 5, 4),
(4, 7, 5),
(5, 5, 5),
(6, 4, 5),
(7, 3, 4),
(8, 5, 4);

--
-- Dumping data for table `f20_step_template_table`
--

INSERT INTO `f20_step_template_table` (`STPID`, `TSID`, `title`, `instructions`, `location`) VALUES
(1, 1, 'Secretary Form', '[participating users = secretary] secretary fills in form f1 to create/generate an App(enter student email, select Course, Faculty, Chair, Dean), the system automatically generates an urgent message from Secretary to the primary user of the NEXT step (Student) and also emails student login info', '/form/formSecretary.php'),
(2, 1, 'Student Form', '[participating users = student] Student fill-in the (fieldwork) form f2 including Supervisor info, the system automatically generates an urgent message from Student to the primary user of the NEXT step (Faculty) and also emails faculty login info.', '/form/formStudent.php'),
(3, 1, 'Faculty 1 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also emails Supervisor login info.', '/form/formFaculty1.php'),
(4, 1, 'Supervisor Form', '[participating users = supervisor] Supervisor fill-in the form f4 to edit/approve LO, the system automatically generates a message from Supervisor to Faculty.', '/form/formSupervisor.php'),
(5, 1, 'Faculty 2 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also emails Supervisor login info.', '/form/formFaculty2.php'),
(6, 1, 'Chair Form', '[participating users = Chair] Chair fill-in the form f5 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/form/formChair.php'),
(7, 1, 'Dean Form', '[participating users = Dean] Dean fill-in the form f6 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/form/formDean.php'),
(8, 1, 'Faculty 3 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also emails Supervisor login info.', '/form/formFaculty3.php');

--
-- Dumping data for table `f20_step_type_table`
--

INSERT INTO `f20_step_type_table` (`STID`, `title`, `info`) VALUES
(1, 'Urgent', 'Step with high priority that should be addressed as soon as possible.'),
(2, 'Normal', 'Step with normal priority.');

--
-- Dumping data for table `f20_template_status_table`
--

INSERT INTO `f20_template_status_table` (`TSID`, `title`, `info`) VALUES
(1, 'Ready', 'Can be used when needed.'),
(2, 'Not-Ready', 'Incomplete or should not be used yet.'),
(3, 'Deleted', 'No longer visible.');

--
-- Dumping data for table `f20_user_role_table`
--

INSERT INTO `f20_user_role_table` (`URID`, `user_role_title`, `user_role_info`) VALUES
(1, 'Administrator', 'Highest access rights.'),
(2, 'Career Resource Center', 'College faculty belonging to the career resource center.'),
(3, 'Records and Registration', 'College faculty belonging to the record and registration office.'),
(4, 'Dean', 'Active deans of the college.'),
(5, 'Chair', 'Active Department Chair.'),
(6, 'Secretary', 'Active Department Secretary.'),
(7, 'Faculty', 'Advisors, Instructors, or other faculty.'),
(8, 'Student', 'Any college student.'),
(9, 'Supervisor', 'Employer or Supervisor not related to the college.');

--
-- Dumping data for table `f20_user_status_table`
--

INSERT INTO `f20_user_status_table` (`USID`, `user_status`, `user_status_info`) VALUES
(1, 'Active', 'Status assigned to users who are registered, approved, and can use the system.'),
(2, 'Passive', 'Status assigned to users who are registered, but haven\'t been given access to the system functions.'),
(3, 'Terminated', 'Status assigned to users who are registered, but who no longer have access to the system.');

--
-- Dumping data for table `f20_user_table`
--

INSERT INTO `f20_user_table` (`UID`, `USID`, `URID`, `user_login_name`, `user_email`, `user_password`, `user_name`, `user_info`) VALUES
(1, 1, 1, 'admin', 'admin@email.com', '1234', 'Admin Administrator', ''),
(2, 1, 2, 'careers', 'crc@email.com', '1234', 'Career Center', ''),
(3, 1, 3, 'records', 'recreg@email.com', '1234', 'Records Registration', ''),
(4, 1, 4, 'dean', 'dean@email.com', '1234', 'Dean D', ''),
(5, 1, 5, 'chair', 'chair@email.com', '1234', 'Chair Department', ''),
(6, 1, 6, 'secretary', 'secretary@email.com', '1234', 'Secretary Department', ''),
(7, 1, 7, 'faculty', 'faculty@email.com', '1234', 'Instructor Advisor', ''),
(8, 1, 8, 'student', 'student@email.com', '1234', 'Student Grades', ''),
(9, 1, 9, 'supervisor', 'supervisor@email.com', '1234', 'Employer Supervisor', ''),
(10, 3, 7, 'instructor', 'instructor2@email.com', '1234', 'In Structor', '');

--
-- Dumping data for table `fieldworkcomment`
--

INSERT INTO `fieldworkcomment` (`FW_ID`, `StudentEmail`, `ProfCom`, `ChairCom`, `DeanCom`, `SupervisorCom`, `CRCCom`) VALUES
(1, '2@2.2', '2@2.2', '2@2.2', '2@2.2', '2@2.2', ''),
(2, '3@3.3', '3@3.3', '3@3.3', '3@3.3', '3@3.3', ''),
(18, '', '', '', '', '', ''),
(19, '', '', '', '', '', ''),
(20, '', '', '', '', '', ''),
(21, '', '', '', '', '', ''),
(22, '', '', '', '', '', ''),
(23, '', '', '', '', '', ''),
(24, '', '', '', '', '', ''),
(25, '', '', '', '', '', ''),
(26, '', '', '', '', '', ''),
(27, '', '', '', '', '', ''),
(28, '', '', '', '', '', ''),
(29, '', '', '', '', '', ''),
(30, '', '', '', '', '', ''),
(31, '', '', '', '', '', ''),
(32, '', '', '', '', '', ''),
(33, '', '', '', '', '', ''),
(34, '', '', '', '', '', ''),
(35, '', '', '', '', '', ''),
(36, '', '', '', '', '', ''),
(37, '', '', '', '', '', ''),
(38, '', '', '', '', '', ''),
(39, '', '', '', '', '', ''),
(40, '', '', '', '', '', ''),
(41, '', '', '', '', '', ''),
(42, '', '', '', '', '', ''),
(43, '', '', '', '', '', ''),
(44, '', '', '', '', '', ''),
(45, '', '', '', '', '', ''),
(46, '', '', '', '', '', ''),
(47, '', '', '', '', '', ''),
(48, '', '', '', '', '', ''),
(49, '', '', '', '', '', ''),
(50, '', '', '', '', '', ''),
(51, '', '', '', '', '', ''),
(52, '', '', '', '', '', ''),
(53, '', '', '', '', '', ''),
(54, '', '', '', '', '', ''),
(55, '', '', '', '', '', ''),
(56, '', '', '', '', '', ''),
(57, '', '', '', '', '', ''),
(58, '', '', '', '', '', ''),
(59, '', '', '', '', '', '');

--
-- Dumping data for table `fieldworkdecision`
--

INSERT INTO `fieldworkdecision` (`FW_ID`, `StudentEmail`, `ProfDec`, `ChairDec`, `DeanDec`, `SupervisorDec`, `CRCDec`) VALUES
(1, '2@2.2', 2, 2, 2, 2, ''),
(2, '3@3.3', 3, 3, 3, 3, '');

--
-- Dumping data for table `fieldworkwho`
--

INSERT INTO `fieldworkwho` (`FW_ID`, `StudentEmail`, `ProfEmail`, `ChairEmail`, `DeanEmail`, `SupervisorEmail`, `SupervisorName`) VALUES
(1, '2@2.2', '2@2.2', '2@2.2', '2@2.2', '2@2.2', '2@2.2'),
(2, '3@3.3', '3@3.3', '3@3.3', '3@3.3', '3@3.3', '3');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
