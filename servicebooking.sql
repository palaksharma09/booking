-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2026 at 05:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `servicebooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(120) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(80) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `landmark` varchar(150) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `booking_time` varchar(20) NOT NULL,
  `payment_method` enum('online','cash') NOT NULL DEFAULT 'online',
  `special_instructions` text DEFAULT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `gst_amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'confirmed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `service_id`, `provider_id`, `full_name`, `phone`, `email`, `address`, `city`, `pincode`, `landmark`, `booking_date`, `booking_time`, `payment_method`, `special_instructions`, `service_price`, `gst_amount`, `total_amount`, `status`, `created_at`) VALUES
(1, 3, 7, 21, 'Varun', '2323232323', 'varun@gmail.com', 'Surat', 'Surat', '395003', 'Near Rampura Petrol Pump', '2026-03-21', '15:00', 'online', '', 949.00, 170.82, 1119.82, 'confirmed', '2026-03-21 16:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `slug`, `title`, `subtitle`, `description`, `image`, `created_at`) VALUES
(1, 'home', 'Home Services', 'Professional home maintenance and cleaning services', 'From deep cleaning to electrical repairs, our home service professionals are here to make your life easier. Book trusted experts for all your home needs.', 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', '2026-03-20 18:10:12'),
(2, 'salon', 'Salon Services', 'Beauty and wellness services at your doorstep', 'Pamper yourself with premium beauty services delivered to your home. Our expert stylists and beauticians use top-quality products.', 'https://images.pexels.com/photos/3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', '2026-03-20 18:10:12'),
(3, 'garage', 'Garage Services', 'Expert car care and maintenance', 'Keep your vehicle in top condition with our professional garage services. From regular maintenance to emergency repairs, we\'ve got you covered.', 'https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', '2026-03-20 18:10:12');

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `provider_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `provider_name` varchar(100) NOT NULL,
  `gender` enum('male','female','other') NOT NULL DEFAULT 'male',
  `phone_no` varchar(15) NOT NULL,
  `email` varchar(120) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(80) DEFAULT NULL,
  `experience_years` int(11) DEFAULT 0,
  `rating` decimal(2,1) DEFAULT 0.0,
  `completed_jobs` int(11) DEFAULT 0,
  `price` decimal(10,2) DEFAULT 0.00,
  `availability` enum('yes','no') DEFAULT 'yes',
  `image_url` varchar(500) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`provider_id`, `service_id`, `provider_name`, `gender`, `phone_no`, `email`, `address`, `city`, `experience_years`, `rating`, `completed_jobs`, `price`, `availability`, `image_url`, `bio`, `created_at`) VALUES
(1, 1, 'Ananya Mehta', 'female', '9100000000', 'ananya.mehta@servicehub-pro.in', '12, Mumbai Service Lane', 'Mumbai', 7, 4.9, 612, 549.00, 'yes', 'https://randomuser.me/api/portraits/women/31.jpg', 'Specialist in deep home cleaning, kitchen degreasing, and hygienic finishing touches.', '2026-03-21 15:48:47'),
(2, 1, 'Rohit Bansal', 'male', '9100000137', 'rohit.bansal@servicehub-pro.in', '12, Thane Service Lane', 'Thane', 5, 4.7, 438, 499.00, 'yes', 'https://randomuser.me/api/portraits/men/12.jpg', 'Reliable for regular home upkeep, sofa vacuuming, and quick turnaround cleaning jobs.', '2026-03-21 15:48:47'),
(3, 1, 'Kavya Iyer', 'female', '9100000274', 'kavya.iyer@servicehub-pro.in', '12, Navi Mumbai Service Lane', 'Navi Mumbai', 6, 4.8, 521, 579.00, 'yes', 'https://randomuser.me/api/portraits/women/45.jpg', 'Known for apartment cleaning plans, balcony cleanup, and eco-safe products.', '2026-03-21 15:48:47'),
(4, 2, 'Arjun Sethi', 'male', '9100000411', 'arjun.sethi@servicehub-pro.in', '13, Delhi Service Lane', 'Delhi', 8, 4.8, 903, 699.00, 'yes', 'https://randomuser.me/api/portraits/men/14.jpg', 'Handles wiring repairs, switchboard replacement, and home safety checks with care.', '2026-03-21 15:48:47'),
(5, 2, 'Nikhil Rao', 'male', '9100000548', 'nikhil.rao@servicehub-pro.in', '13, Pune Service Lane', 'Pune', 5, 4.6, 477, 629.00, 'yes', 'https://randomuser.me/api/portraits/men/18.jpg', 'Experienced in fan fitting, lighting setup, and apartment electrical troubleshooting.', '2026-03-21 15:48:47'),
(6, 2, 'Ishita Kulkarni', 'female', '9100000685', 'ishita.kulkarni@servicehub-pro.in', '13, Bengaluru Service Lane', 'Bengaluru', 9, 4.9, 1115, 749.00, 'yes', 'https://randomuser.me/api/portraits/women/26.jpg', 'Focuses on premium electrical diagnostics, inverter support, and neat installations.', '2026-03-21 15:48:47'),
(7, 3, 'Meera Joshi', 'female', '9100000822', 'meera.joshi@servicehub-pro.in', '14, Mumbai Service Lane', 'Mumbai', 10, 4.9, 684, 899.00, 'yes', 'https://randomuser.me/api/portraits/women/33.jpg', 'Home chef for daily meals, family menus, and balanced vegetarian cooking.', '2026-03-21 15:48:47'),
(8, 3, 'Dev Malhotra', 'male', '9100000959', 'dev.malhotra@servicehub-pro.in', '14, Gurugram Service Lane', 'Gurugram', 6, 4.7, 359, 799.00, 'yes', 'https://randomuser.me/api/portraits/men/22.jpg', 'Specializes in North Indian meal prep, tiffin planning, and event cooking assistance.', '2026-03-21 15:48:47'),
(9, 3, 'Rhea Kapoor', 'female', '9100001096', 'rhea.kapoor@servicehub-pro.in', '14, Noida Service Lane', 'Noida', 7, 4.8, 428, 849.00, 'yes', 'https://randomuser.me/api/portraits/women/41.jpg', 'Popular for custom meal plans, festive menus, and clean kitchen workflow.', '2026-03-21 15:48:47'),
(10, 4, 'Samar Choudhary', 'male', '9100001233', 'samar.choudhary@servicehub-pro.in', '15, Jaipur Service Lane', 'Jaipur', 9, 4.8, 952, 729.00, 'yes', 'https://randomuser.me/api/portraits/men/16.jpg', 'Fixes leaks, faucet issues, and bathroom pipe work with fast same-day support.', '2026-03-21 15:48:47'),
(11, 4, 'Harsh Vora', 'male', '9100001370', 'harsh.vora@servicehub-pro.in', '15, Ahmedabad Service Lane', 'Ahmedabad', 5, 4.6, 406, 649.00, 'yes', 'https://randomuser.me/api/portraits/men/27.jpg', 'Good for kitchen fittings, drain cleaning, and practical low-cost plumbing repairs.', '2026-03-21 15:48:47'),
(12, 4, 'Tanya Dsouza', 'female', '9100001507', 'tanya.dsouza@servicehub-pro.in', '15, Mumbai Service Lane', 'Mumbai', 8, 4.9, 878, 779.00, 'yes', 'https://randomuser.me/api/portraits/women/36.jpg', 'Trusted for premium plumbing service, geyser line checks, and tidy finish quality.', '2026-03-21 15:48:47'),
(13, 5, 'Yash Pradhan', 'male', '9100001644', 'yash.pradhan@servicehub-pro.in', '16, Pune Service Lane', 'Pune', 7, 4.7, 366, 1599.00, 'yes', 'https://randomuser.me/api/portraits/men/19.jpg', 'Interior wall painting expert with smooth finishing and low-mess execution.', '2026-03-21 15:48:47'),
(14, 5, 'Sneha Tiwari', 'female', '9100001781', 'sneha.tiwari@servicehub-pro.in', '16, Lucknow Service Lane', 'Lucknow', 6, 4.8, 314, 1699.00, 'yes', 'https://randomuser.me/api/portraits/women/29.jpg', 'Known for room refresh projects, color consultation, and detail-oriented touch-ups.', '2026-03-21 15:48:47'),
(15, 5, 'Kunal Oberoi', 'male', '9100001918', 'kunal.oberoi@servicehub-pro.in', '16, Delhi Service Lane', 'Delhi', 4, 4.6, 205, 1499.00, 'yes', 'https://randomuser.me/api/portraits/men/11.jpg', 'Handles budget-friendly interior painting, ceiling coats, and quick repaint jobs.', '2026-03-21 15:48:47'),
(16, 6, 'Aman Khanna', 'male', '9100002055', 'aman.khanna@servicehub-pro.in', '17, Gurugram Service Lane', 'Gurugram', 6, 4.8, 498, 699.00, 'yes', 'https://randomuser.me/api/portraits/men/21.jpg', 'Efficient with beds, wardrobes, study tables, and modular furniture assembly.', '2026-03-21 15:48:47'),
(17, 6, 'Pallavi Nair', 'female', '9100002192', 'pallavi.nair@servicehub-pro.in', '17, Kochi Service Lane', 'Kochi', 5, 4.7, 287, 749.00, 'yes', 'https://randomuser.me/api/portraits/women/34.jpg', 'Strong at compact-space assembly, hardware sorting, and neat final alignment.', '2026-03-21 15:48:47'),
(18, 6, 'Vivek Luthra', 'male', '9100002329', 'vivek.luthra@servicehub-pro.in', '17, Chandigarh Service Lane', 'Chandigarh', 8, 4.9, 541, 799.00, 'yes', 'https://randomuser.me/api/portraits/men/17.jpg', 'Experienced in premium furniture setup, wall-mount jobs, and repair adjustments.', '2026-03-21 15:48:47'),
(19, 7, 'Rajat Menon', 'male', '9100002466', 'rajat.menon@servicehub-pro.in', '18, Chennai Service Lane', 'Chennai', 9, 4.8, 836, 899.00, 'yes', 'https://randomuser.me/api/portraits/men/24.jpg', 'Performs AC servicing, gas checks, cooling diagnostics, and preventive maintenance.', '2026-03-21 15:48:47'),
(20, 7, 'Pooja Salvi', 'female', '9100002603', 'pooja.salvi@servicehub-pro.in', '18, Pune Service Lane', 'Pune', 6, 4.7, 442, 849.00, 'yes', 'https://randomuser.me/api/portraits/women/38.jpg', 'Reliable for split AC cleaning, filter replacement, and seasonal tune-up visits.', '2026-03-21 15:48:47'),
(21, 7, 'Aditya Kohli', 'male', '9100002740', 'aditya.kohli@servicehub-pro.in', '18, Delhi Service Lane', 'Delhi', 10, 4.9, 973, 949.00, 'yes', 'https://randomuser.me/api/portraits/men/13.jpg', 'High-rated technician for premium AC repair, compressor inspection, and fast diagnosis.', '2026-03-21 15:48:47'),
(22, 8, 'Shaurya Mirza', 'male', '9100002877', 'shaurya.mirza@servicehub-pro.in', '19, Hyderabad Service Lane', 'Hyderabad', 7, 4.8, 515, 499.00, 'yes', 'https://randomuser.me/api/portraits/men/28.jpg', 'Handles door lock repair, latch replacement, and secure key duplication support.', '2026-03-21 15:48:47'),
(23, 8, 'Naina Bhagat', 'female', '9100003014', 'naina.bhagat@servicehub-pro.in', '19, Jaipur Service Lane', 'Jaipur', 5, 4.7, 241, 459.00, 'yes', 'https://randomuser.me/api/portraits/women/44.jpg', 'Good for apartment lock changes, cupboard locks, and emergency visit coordination.', '2026-03-21 15:48:47'),
(24, 8, 'Rishabh Pathak', 'male', '9100003151', 'rishabh.pathak@servicehub-pro.in', '19, Indore Service Lane', 'Indore', 8, 4.9, 589, 549.00, 'yes', 'https://randomuser.me/api/portraits/men/20.jpg', 'Known for premium lock installation, smart lock fitting, and quick response work.', '2026-03-21 15:48:47'),
(25, 9, 'Manav Chopra', 'male', '9100003288', 'manav.chopra@servicehub-pro.in', '20, Noida Service Lane', 'Noida', 8, 4.8, 724, 2199.00, 'yes', 'https://randomuser.me/api/portraits/men/25.jpg', 'Coordinates careful home shifting, packing crews, and fragile-item handling.', '2026-03-21 15:48:47'),
(26, 9, 'Bhavna Arora', 'female', '9100003425', 'bhavna.arora@servicehub-pro.in', '20, Delhi Service Lane', 'Delhi', 6, 4.7, 338, 1999.00, 'yes', 'https://randomuser.me/api/portraits/women/32.jpg', 'Strong at apartment moves, labeling systems, and kitchenware packing support.', '2026-03-21 15:48:47'),
(27, 9, 'Lakshya Shetty', 'male', '9100003562', 'lakshya.shetty@servicehub-pro.in', '20, Bengaluru Service Lane', 'Bengaluru', 9, 4.9, 811, 2299.00, 'yes', 'https://randomuser.me/api/portraits/men/15.jpg', 'Premium moving specialist for full-house relocation, loading plans, and safe transport.', '2026-03-21 15:48:47'),
(28, 10, 'Aarav Puri', 'male', '9100003699', 'aarav.puri@servicehub-pro.in', '21, Delhi Service Lane', 'Delhi', 8, 4.9, 1266, 449.00, 'yes', 'https://randomuser.me/api/portraits/men/23.jpg', 'Stylish barber for fades, beard shaping, and polished at-home grooming sessions.', '2026-03-21 15:48:47'),
(29, 10, 'Simran Wagle', 'female', '9100003836', 'simran.wagle@servicehub-pro.in', '21, Mumbai Service Lane', 'Mumbai', 7, 4.8, 918, 499.00, 'yes', 'https://randomuser.me/api/portraits/women/37.jpg', 'Popular for women haircut styling, trims, and personalized face-shape recommendations.', '2026-03-21 15:48:47'),
(30, 10, 'Ishan Bakshi', 'male', '9100003973', 'ishan.bakshi@servicehub-pro.in', '21, Chandigarh Service Lane', 'Chandigarh', 5, 4.7, 547, 399.00, 'yes', 'https://randomuser.me/api/portraits/men/10.jpg', 'Handles classic cuts, kids styling, and neat quick-service appointments.', '2026-03-21 15:48:47'),
(31, 11, 'Diya Talwar', 'female', '9100004110', 'diya.talwar@servicehub-pro.in', '22, Delhi Service Lane', 'Delhi', 9, 4.9, 1107, 899.00, 'yes', 'https://randomuser.me/api/portraits/women/42.jpg', 'Premium skincare specialist for glow facials, cleanup routines, and bridal prep.', '2026-03-21 15:48:47'),
(32, 11, 'Aditi Fernandes', 'female', '9100004247', 'aditi.fernandes@servicehub-pro.in', '22, Goa Service Lane', 'Goa', 6, 4.8, 733, 799.00, 'yes', 'https://randomuser.me/api/portraits/women/35.jpg', 'Known for hydration facials, sensitive-skin care, and product-safe sessions.', '2026-03-21 15:48:47'),
(33, 11, 'Varun Bedi', 'male', '9100004384', 'varun.bedi@servicehub-pro.in', '22, Noida Service Lane', 'Noida', 5, 4.6, 412, 749.00, 'yes', 'https://randomuser.me/api/portraits/men/29.jpg', 'Offers clean facial routines, de-tan sessions, and men grooming skin treatments.', '2026-03-21 15:48:47'),
(34, 12, 'Kiara Mistry', 'female', '9100004521', 'kiara.mistry@servicehub-pro.in', '23, Mumbai Service Lane', 'Mumbai', 10, 4.9, 962, 1499.00, 'yes', 'https://randomuser.me/api/portraits/women/46.jpg', 'Bridal and event makeup artist known for HD looks and long-wear finishes.', '2026-03-21 15:48:47'),
(35, 12, 'Sana Qureshi', 'female', '9100004658', 'sana.qureshi@servicehub-pro.in', '23, Hyderabad Service Lane', 'Hyderabad', 7, 4.8, 708, 1399.00, 'yes', 'https://randomuser.me/api/portraits/women/39.jpg', 'Specializes in soft glam, engagement looks, and skin-first makeup styling.', '2026-03-21 15:48:47'),
(36, 12, 'Ritvik Anand', 'male', '9100004795', 'ritvik.anand@servicehub-pro.in', '23, Patna Service Lane', 'Patna', 6, 4.7, 489, 1299.00, 'yes', 'https://randomuser.me/api/portraits/men/30.jpg', 'Reliable for party makeup, festive looks, and quick ready-to-go appointments.', '2026-03-21 15:48:47'),
(37, 13, 'Tara Bhasin', 'female', '9100004932', 'tara.bhasin@servicehub-pro.in', '24, Delhi Service Lane', 'Delhi', 8, 4.9, 856, 599.00, 'yes', 'https://randomuser.me/api/portraits/women/43.jpg', 'Nail care expert for manicure, pedicure, cuticle cleanup, and polish detailing.', '2026-03-21 15:48:47'),
(38, 13, 'Mitali Gokhale', 'female', '9100005069', 'mitali.gokhale@servicehub-pro.in', '24, Pune Service Lane', 'Pune', 6, 4.8, 544, 549.00, 'yes', 'https://randomuser.me/api/portraits/women/47.jpg', 'Great with home salon hygiene, gel polish basics, and soothing foot care.', '2026-03-21 15:48:47'),
(39, 13, 'Omkar Jadhav', 'male', '9100005206', 'omkar.jadhav@servicehub-pro.in', '24, Mumbai Service Lane', 'Mumbai', 4, 4.6, 273, 499.00, 'yes', 'https://randomuser.me/api/portraits/men/31.jpg', 'Provides efficient manicure and pedicure sessions with a clean professional setup.', '2026-03-21 15:48:47'),
(40, 14, 'Riddhi Parekh', 'female', '9100005343', 'riddhi.parekh@servicehub-pro.in', '25, Ahmedabad Service Lane', 'Ahmedabad', 9, 4.9, 687, 1299.00, 'yes', 'https://randomuser.me/api/portraits/women/48.jpg', 'Spa therapist for relaxation massage, stress relief sessions, and calm home setups.', '2026-03-21 15:48:47'),
(41, 14, 'Karan Nanda', 'male', '9100005480', 'karan.nanda@servicehub-pro.in', '25, Delhi Service Lane', 'Delhi', 6, 4.7, 433, 1199.00, 'yes', 'https://randomuser.me/api/portraits/men/26.jpg', 'Known for body spa routines, recovery-focused sessions, and respectful service.', '2026-03-21 15:48:47'),
(42, 14, 'Esha Batra', 'female', '9100005617', 'esha.batra@servicehub-pro.in', '25, Jaipur Service Lane', 'Jaipur', 7, 4.8, 511, 1249.00, 'yes', 'https://randomuser.me/api/portraits/women/40.jpg', 'Offers premium wellness treatments, aroma sessions, and balanced pressure techniques.', '2026-03-21 15:48:47'),
(43, 15, 'Prisha Kohar', 'female', '9100005754', 'prisha.kohar@servicehub-pro.in', '26, Mumbai Service Lane', 'Mumbai', 11, 4.9, 802, 4999.00, 'yes', 'https://randomuser.me/api/portraits/women/49.jpg', 'Complete bridal package expert covering makeup, hair, draping, and timeline planning.', '2026-03-21 15:48:47'),
(44, 15, 'Yamini Sood', 'female', '9100005891', 'yamini.sood@servicehub-pro.in', '26, Ludhiana Service Lane', 'Ludhiana', 8, 4.8, 566, 4599.00, 'yes', 'https://randomuser.me/api/portraits/women/50.jpg', 'Strong in traditional bridal looks, family-event prep, and calm wedding-day support.', '2026-03-21 15:48:47'),
(45, 15, 'Charvi Bedi', 'female', '9100006028', 'charvi.bedi@servicehub-pro.in', '26, Delhi Service Lane', 'Delhi', 6, 4.7, 391, 4299.00, 'yes', 'https://randomuser.me/api/portraits/women/51.jpg', 'Handles intimate wedding packages, soft bridal glam, and saree draping assistance.', '2026-03-21 15:48:47'),
(46, 16, 'Lavanya Pillai', 'female', '9100006165', 'lavanya.pillai@servicehub-pro.in', '27, Chennai Service Lane', 'Chennai', 8, 4.9, 721, 1599.00, 'yes', 'https://randomuser.me/api/portraits/women/52.jpg', 'Hair color specialist for global shades, root touch-ups, and post-color care.', '2026-03-21 15:48:47'),
(47, 16, 'Daksh Ahuja', 'male', '9100006302', 'daksh.ahuja@servicehub-pro.in', '27, Delhi Service Lane', 'Delhi', 5, 4.7, 438, 1399.00, 'yes', 'https://randomuser.me/api/portraits/men/32.jpg', 'Handles men and women hair color, tone correction, and clean application work.', '2026-03-21 15:48:47'),
(48, 16, 'Mahira Shah', 'female', '9100006439', 'mahira.shah@servicehub-pro.in', '27, Ahmedabad Service Lane', 'Ahmedabad', 7, 4.8, 612, 1499.00, 'yes', 'https://randomuser.me/api/portraits/women/53.jpg', 'Known for highlights, balayage-inspired styling, and gentle product handling.', '2026-03-21 15:48:47'),
(49, 17, 'Reyansh Dua', 'male', '9100006576', 'reyansh.dua@servicehub-pro.in', '28, Delhi Service Lane', 'Delhi', 6, 4.8, 404, 999.00, 'yes', 'https://randomuser.me/api/portraits/men/33.jpg', 'Supports home steam setups, wellness routines, and safe guided recovery sessions.', '2026-03-21 15:48:47'),
(50, 17, 'Niharika Sen', 'female', '9100006713', 'niharika.sen@servicehub-pro.in', '28, Kolkata Service Lane', 'Kolkata', 7, 4.9, 466, 1099.00, 'yes', 'https://randomuser.me/api/portraits/women/54.jpg', 'Offers premium steam and sauna guidance focused on comfort and relaxation.', '2026-03-21 15:48:47'),
(51, 17, 'Krish Taneja', 'male', '9100006850', 'krish.taneja@servicehub-pro.in', '28, Noida Service Lane', 'Noida', 5, 4.7, 312, 949.00, 'yes', 'https://randomuser.me/api/portraits/men/34.jpg', 'Reliable for compact wellness setups and smooth appointment management.', '2026-03-21 15:48:47'),
(52, 18, 'Parth Solanki', 'male', '9100006987', 'parth.solanki@servicehub-pro.in', '29, Ahmedabad Service Lane', 'Ahmedabad', 8, 4.9, 1314, 499.00, 'yes', 'https://randomuser.me/api/portraits/men/35.jpg', 'Detailed car wash professional with strong focus on exterior shine and clean interiors.', '2026-03-21 15:48:47'),
(53, 18, 'Abir Mukherjee', 'male', '9100007124', 'abir.mukherjee@servicehub-pro.in', '29, Kolkata Service Lane', 'Kolkata', 7, 4.8, 884, 449.00, 'yes', 'https://randomuser.me/api/portraits/men/36.jpg', 'Fast and dependable for hatchback and sedan wash, vacuuming, and dashboard cleanup.', '2026-03-21 15:48:47'),
(54, 18, 'Suhani Deshmukh', 'female', '9100007261', 'suhani.deshmukh@servicehub-pro.in', '29, Pune Service Lane', 'Pune', 5, 4.7, 533, 529.00, 'yes', 'https://randomuser.me/api/portraits/women/55.jpg', 'Known for premium wash packages, alloy detailing, and spotless finishing.', '2026-03-21 15:48:47'),
(55, 19, 'Zayan Contractor', 'male', '9100007398', 'zayan.contractor@servicehub-pro.in', '30, Mumbai Service Lane', 'Mumbai', 11, 4.9, 1175, 1499.00, 'yes', 'https://randomuser.me/api/portraits/men/37.jpg', 'Automobile repair specialist for engine issues, suspension checks, and practical diagnostics.', '2026-03-21 15:48:47'),
(56, 19, 'Anshul Dahiya', 'male', '9100007535', 'anshul.dahiya@servicehub-pro.in', '30, Faridabad Service Lane', 'Faridabad', 8, 4.8, 836, 1299.00, 'yes', 'https://randomuser.me/api/portraits/men/38.jpg', 'Good with everyday car repairs, brake work, and workshop-quality doorstep service.', '2026-03-21 15:48:47'),
(57, 19, 'Ira Thomas', 'female', '9100007672', 'ira.thomas@servicehub-pro.in', '30, Kochi Service Lane', 'Kochi', 6, 4.7, 492, 1399.00, 'yes', 'https://randomuser.me/api/portraits/women/56.jpg', 'Handles premium repair coordination, inspection notes, and transparent recommendations.', '2026-03-21 15:48:47'),
(58, 20, 'Yuvan Saran', 'male', '9100007809', 'yuvan.saran@servicehub-pro.in', '31, Lucknow Service Lane', 'Lucknow', 7, 4.8, 968, 699.00, 'yes', 'https://randomuser.me/api/portraits/men/39.jpg', 'Efficient with oil changes, filter replacement, and engine health basic checks.', '2026-03-21 15:48:47'),
(59, 20, 'Manya Chawla', 'female', '9100007946', 'manya.chawla@servicehub-pro.in', '31, Delhi Service Lane', 'Delhi', 5, 4.7, 377, 649.00, 'yes', 'https://randomuser.me/api/portraits/women/57.jpg', 'Reliable for doorstep oil service, fluid level review, and clean disposal handling.', '2026-03-21 15:48:47'),
(60, 20, 'Kabir Dalmia', 'male', '9100008083', 'kabir.dalmia@servicehub-pro.in', '31, Jaipur Service Lane', 'Jaipur', 9, 4.9, 1051, 749.00, 'yes', 'https://randomuser.me/api/portraits/men/40.jpg', 'Premium technician for oil grade selection, smooth service flow, and preventive care.', '2026-03-21 15:48:47'),
(61, 21, 'Arnav Khatri', 'male', '9100008220', 'arnav.khatri@servicehub-pro.in', '32, Delhi Service Lane', 'Delhi', 8, 4.8, 612, 899.00, 'yes', 'https://randomuser.me/api/portraits/men/41.jpg', 'Battery diagnostics expert for replacements, charging checks, and jump-start support.', '2026-03-21 15:48:47'),
(62, 21, 'Jiya Sibal', 'female', '9100008357', 'jiya.sibal@servicehub-pro.in', '32, Chandigarh Service Lane', 'Chandigarh', 5, 4.7, 298, 849.00, 'yes', 'https://randomuser.me/api/portraits/women/58.jpg', 'Good for quick battery testing, terminal cleanup, and reliable customer communication.', '2026-03-21 15:48:47'),
(63, 21, 'Vihaan Sidhu', 'male', '9100008494', 'vihaan.sidhu@servicehub-pro.in', '32, Ludhiana Service Lane', 'Ludhiana', 10, 4.9, 754, 949.00, 'yes', 'https://randomuser.me/api/portraits/men/42.jpg', 'Handles premium battery service with detailed checks and branded replacement guidance.', '2026-03-21 15:48:47'),
(64, 22, 'Tushar Pahwa', 'male', '9100008631', 'tushar.pahwa@servicehub-pro.in', '33, Delhi Service Lane', 'Delhi', 9, 4.8, 846, 999.00, 'yes', 'https://randomuser.me/api/portraits/men/43.jpg', 'Tire rotation, alignment support, puncture handling, and wear pattern inspection.', '2026-03-21 15:48:47'),
(65, 22, 'Ayesha Narang', 'female', '9100008768', 'ayesha.narang@servicehub-pro.in', '33, Gurugram Service Lane', 'Gurugram', 6, 4.7, 369, 949.00, 'yes', 'https://randomuser.me/api/portraits/women/59.jpg', 'Careful with wheel balancing coordination and sedan-focused maintenance work.', '2026-03-21 15:48:47'),
(66, 22, 'Ronit Sengar', 'male', '9100008905', 'ronit.sengar@servicehub-pro.in', '33, Indore Service Lane', 'Indore', 11, 4.9, 932, 1049.00, 'yes', 'https://randomuser.me/api/portraits/men/44.jpg', 'Trusted for premium tire service, replacement advice, and smooth road-readiness checks.', '2026-03-21 15:48:47'),
(67, 23, 'Atharv Grewal', 'male', '9100009042', 'atharv.grewal@servicehub-pro.in', '34, Delhi Service Lane', 'Delhi', 8, 4.9, 1018, 1199.00, 'yes', 'https://randomuser.me/api/portraits/men/45.jpg', 'Computer diagnostics specialist for dashboard alerts, sensor issues, and fault scanning.', '2026-03-21 15:48:47'),
(68, 23, 'Myra Awasthi', 'female', '9100009179', 'myra.awasthi@servicehub-pro.in', '34, Noida Service Lane', 'Noida', 6, 4.8, 427, 1099.00, 'yes', 'https://randomuser.me/api/portraits/women/60.jpg', 'Known for clear explanation of diagnostic reports and practical repair guidance.', '2026-03-21 15:48:47'),
(69, 23, 'Siddhant Purohit', 'male', '9100009316', 'siddhant.purohit@servicehub-pro.in', '34, Udaipur Service Lane', 'Udaipur', 5, 4.7, 315, 1149.00, 'yes', 'https://randomuser.me/api/portraits/men/46.jpg', 'Reliable for fast vehicle scans, basic electrical diagnosis, and maintenance recommendations.', '2026-03-21 15:48:47'),
(70, 24, 'Pranav Wadhwa', 'male', '9100009453', 'pranav.wadhwa@servicehub-pro.in', '35, Delhi Service Lane', 'Delhi', 9, 4.9, 886, 999.00, 'yes', 'https://randomuser.me/api/portraits/men/47.jpg', 'Car AC expert for cooling diagnostics, gas refill checks, and airflow restoration.', '2026-03-21 15:48:47'),
(71, 24, 'Zara Monga', 'female', '9100009590', 'zara.monga@servicehub-pro.in', '35, Noida Service Lane', 'Noida', 6, 4.8, 401, 949.00, 'yes', 'https://randomuser.me/api/portraits/women/61.jpg', 'Popular for clean AC servicing, odor control, and compact car support.', '2026-03-21 15:48:47'),
(72, 24, 'Aryan Hegde', 'male', '9100009727', 'aryan.hegde@servicehub-pro.in', '35, Bengaluru Service Lane', 'Bengaluru', 5, 4.7, 356, 899.00, 'yes', 'https://randomuser.me/api/portraits/men/48.jpg', 'Handles routine car AC service, vent inspection, and quick cooling performance fixes.', '2026-03-21 15:48:47'),
(73, 25, 'Devansh Choksi', 'male', '9100009864', 'devansh.choksi@servicehub-pro.in', '36, Ahmedabad Service Lane', 'Ahmedabad', 10, 4.9, 779, 1799.00, 'yes', 'https://randomuser.me/api/portraits/men/49.jpg', 'Premium car detailing specialist for paint shine, cabin polish, and finish protection.', '2026-03-21 15:48:47'),
(74, 25, 'Vanya Sachdeva', 'female', '9100010001', 'vanya.sachdeva@servicehub-pro.in', '36, Delhi Service Lane', 'Delhi', 7, 4.8, 544, 1699.00, 'yes', 'https://randomuser.me/api/portraits/women/62.jpg', 'Known for interior detailing, stain lifting, and premium exterior finish work.', '2026-03-21 15:48:47'),
(75, 25, 'Neil Rajput', 'male', '9100010138', 'neil.rajput@servicehub-pro.in', '36, Bhopal Service Lane', 'Bhopal', 6, 4.7, 438, 1599.00, 'yes', 'https://randomuser.me/api/portraits/men/50.jpg', 'Reliable for practical detailing packages, dashboard restoration, and wash-plus-polish jobs.', '2026-03-21 15:48:47');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL COMMENT 'Stores icon class (FontAwesome) or SVG path',
  `icon_type` enum('fontawesome','svg') DEFAULT 'fontawesome' COMMENT 'Specifies icon rendering method',
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `professional_count` int(11) DEFAULT 0,
  `is_popular` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `icon`, `icon_type`, `name`, `description`, `professional_count`, `is_popular`, `created_at`) VALUES
(1, 1, 'fa-solid fa-broom', 'fontawesome', 'Cleaning', 'Deep cleaning, regular maintenance', 3, 1, '2026-03-20 18:11:25'),
(2, 1, 'fa-solid fa-bolt', 'fontawesome', 'Electrician', 'Repairs, installation, wiring', 3, 1, '2026-03-20 18:11:25'),
(3, 1, 'fa-solid fa-utensils', 'fontawesome', 'Cooking', 'Home chefs, meal preparation', 3, 0, '2026-03-20 18:11:25'),
(4, 1, 'fa-solid fa-wrench', 'fontawesome', 'Plumbing', 'Pipe repair, fixture installation', 3, 1, '2026-03-20 18:11:25'),
(5, 1, 'fa-solid fa-paint-roller', 'fontawesome', 'Painting', 'Interior & exterior painting', 3, 0, '2026-03-20 18:11:25'),
(6, 1, 'fa-solid fa-couch', 'fontawesome', 'Furniture Assembly', 'Assembly & repair', 3, 0, '2026-03-20 18:11:25'),
(7, 1, 'fa-solid fa-snowflake', 'fontawesome', 'AC Service', 'Repair & maintenance', 3, 1, '2026-03-20 18:11:25'),
(8, 1, 'fa-solid fa-key', 'fontawesome', 'Locksmith', 'Lock repair, installation', 3, 0, '2026-03-20 18:11:25'),
(9, 1, 'fa-solid fa-boxes', 'fontawesome', 'Packing & Moving', 'Home shifting services', 3, 0, '2026-03-20 18:11:25'),
(10, 2, 'fa-solid fa-scissors', 'fontawesome', 'Haircut', 'Men & women haircut, styling', 3, 1, '2026-03-20 18:11:25'),
(11, 2, 'fa-solid fa-spa', 'fontawesome', 'Facial', 'Premium skincare treatments', 3, 1, '2026-03-20 18:11:25'),
(12, 2, 'fa-solid fa-brush', 'fontawesome', 'Make-up', 'Party, bridal makeup', 3, 1, '2026-03-20 18:11:25'),
(13, 2, 'fa-solid fa-hand-sparkles', 'fontawesome', 'Manicure/Pedicure', 'Nail care services', 3, 1, '2026-03-20 18:11:25'),
(14, 2, 'fa-solid fa-hot-tub', 'fontawesome', 'Spa', 'Massage, relaxation therapy', 3, 0, '2026-03-20 18:11:25'),
(15, 2, 'fa-solid fa-rings-wedding', 'fontawesome', 'Bridal Package', 'Complete bridal makeover', 3, 0, '2026-03-20 18:11:25'),
(16, 2, 'fa-solid fa-palette', 'fontawesome', 'Hair Color', 'Professional coloring', 3, 1, '2026-03-20 18:11:25'),
(17, 2, 'fa-solid fa-hot-tub-person', 'fontawesome', 'Steam & Sauna', 'Relaxation therapies', 3, 0, '2026-03-20 18:11:25'),
(18, 3, 'fa-solid fa-car-wash', 'fontawesome', 'Car Wash', 'Professional cleaning, waxing', 3, 1, '2026-03-20 18:11:26'),
(19, 3, 'fa-solid fa-screwdriver-wrench', 'fontawesome', 'Repair', 'Engine, transmission repair', 3, 1, '2026-03-20 18:11:26'),
(20, 3, 'fa-solid fa-oil-can', 'fontawesome', 'Oil Change', 'Engine oil, filter change', 3, 1, '2026-03-20 18:11:26'),
(21, 3, 'fa-solid fa-car-battery', 'fontawesome', 'Battery Service', 'Battery check, replacement', 3, 0, '2026-03-20 18:11:26'),
(22, 3, 'fa-solid fa-tire', 'fontawesome', 'Tire Service', 'Tire rotation, alignment', 3, 1, '2026-03-20 18:11:26'),
(23, 3, 'fa-solid fa-microchip', 'fontawesome', 'Diagnostics', 'Computer diagnostics', 3, 0, '2026-03-20 18:11:26'),
(24, 3, 'fa-solid fa-wind', 'fontawesome', 'AC Service', 'Car AC repair', 3, 1, '2026-03-20 18:11:26'),
(25, 3, 'fa-solid fa-spray-can-sparkles', 'fontawesome', 'Detailing', 'Complete car detailing', 3, 0, '2026-03-20 18:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_email_id` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `user_email_id`, `phone`, `address`, `dob`, `role`, `created_at`) VALUES
(2, 'Palak Sharma', '123456', 'palaksharma932004@gmail.com', '1234567890', '', NULL, 'user', '2020-12-31 18:45:54'),
(3, 'Varun', '111111', 'varun@gmail.com', '2323232323', 'Surat', '2000-01-01', 'user', '2026-03-19 20:42:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `idx_booking_user` (`user_id`),
  ADD KEY `idx_booking_service` (`service_id`),
  ADD KEY `idx_booking_provider` (`provider_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`provider_id`),
  ADD UNIQUE KEY `uniq_provider_email` (`email`),
  ADD KEY `idx_provider_service` (`service_id`),
  ADD KEY `idx_provider_availability` (`availability`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_popular` (`is_popular`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email_id` (`user_email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`) ON DELETE CASCADE;

--
-- Constraints for table `provider`
--
ALTER TABLE `provider`
  ADD CONSTRAINT `provider_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
