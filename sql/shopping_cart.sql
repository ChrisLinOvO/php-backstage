-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-05-01 00:56:52
-- 伺服器版本： 10.4.11-MariaDB
-- PHP 版本： 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `shopping_cart`
--

-- --------------------------------------------------------

--
-- 資料表結構 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL COMMENT '流水號',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者帳號',
  `pwd` char(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者密碼',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '管理者姓名',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理者帳號';

--
-- 傾印資料表的資料 `admin`
--

INSERT INTO `admin` (`id`, `username`, `pwd`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '最高管理者', '2020-04-23 10:04:13', '2020-04-23 10:04:13');

-- --------------------------------------------------------

--
-- 資料表結構 `articlecategories`
--

CREATE TABLE `articlecategories` (
  `articleCategoryId` int(11) NOT NULL COMMENT '流水號',
  `articleCategoryName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章類別名稱',
  `articleCategoryParentId` int(11) DEFAULT 0 COMMENT '上層編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章類別資料表';

--
-- 傾印資料表的資料 `articlecategories`
--

INSERT INTO `articlecategories` (`articleCategoryId`, `articleCategoryName`, `articleCategoryParentId`, `created_at`, `updated_at`) VALUES
(1, '重訓教學', 0, '2020-04-29 10:08:49', '2020-04-29 10:08:49'),
(2, '營養學', 0, '2020-04-27 01:14:01', '2020-04-27 01:14:01'),
(3, '生酮飲食', 0, '2020-04-27 01:16:09', '2020-04-27 01:16:09'),
(4, '減重知識', 0, '2020-04-27 01:16:25', '2020-04-27 01:16:25');

-- --------------------------------------------------------

--
-- 資料表結構 `articles`
--

CREATE TABLE `articles` (
  `articleId` int(11) NOT NULL COMMENT '流水號',
  `articleName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章名稱',
  `articleImg` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章照片路徑',
  `articleContents` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章內容',
  `articleCategoryId` int(11) NOT NULL COMMENT '文章種類編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章列表';

--
-- 傾印資料表的資料 `articles`
--

INSERT INTO `articles` (`articleId`, `articleName`, `articleImg`, `articleContents`, `articleCategoryId`, `created_at`, `updated_at`) VALUES
(1, '健身新手該怎麼開始訓練？', 'article_20200429041148.jpg', '第一，剛接觸健身的新手該怎麼做？\r\n\r\n在身為健身新手的你演化成健人之前，你對於健身什麼都不懂，進健身房就是去做二頭彎舉跟動作不標準的胸推吧？ 此時的你有幾個重點要注意：\r\n \r\n1. 投入最重要的六個主要動作 深蹲 硬舉 臥推 划船 肩推 下拉\r\n\r\n 2. 找到肌肉不平衡的地方並且修正它 比如說你有圓肩、骨盆前傾、駝背之類的，就是要去放鬆過緊繃的肌群，然後去強化過度被拉長或是無力的肌群，同時找正常的關節活動度 如果你不在這個階段修正好的話，下個階段開始加訓練強度的時候，你的關節就會很容易爆掉。\r\n\r\n 3. 強化核心 大部分的人核心都挺弱的，把強化核心這個輔助技能點起來的話 對身為健身新手的你的主要六大動作以及之後的訓練都會有幫助 健身新手的每日課表 這時健身新手的每日課表流程應該會是： \r\n1. 先放鬆伸展 \r\n2. 挑3個主要動作來練 一組12~15下做三到四組，然後節奏要慢，離心可以數三秒、等長一秒、向心兩秒，組間休息60~90秒鐘 基本上就是用很輕的重量做高次數的訓練，然後重複去練習這些動作來提昇動作熟練度 \r\n3. 訓練核心以及過弱的肌群', 1, '2020-04-27 10:17:09', '2020-04-29 17:02:54'),
(2, '增肌重訓課表安排大全', 'article_20200429041656.jpg', '訓練菜單 – 好兄弟分法（bro split）：胸 – 腿 – 手 – 肩 – 背 – 休息 \r\n好處：  \r\n可以加強針對小肌群 好上手 \r\n壞處：\r\n頻率低，一個部位只能練一次 肌肉量提升較慢訓練菜單 – 推拉腿分法：\r\n推 – 拉 – 腿 – 推 – 拉 – 腿 – 休息 推就是胸＋肩＋三頭 拉就是背＋二頭 腿就是腿，可以加個核心訓練。\r\n好處： \r\n頻率高，一個部位一星期可以練兩次 把相同功能的肌群放在一起練 一次大概只需要練40-50分鐘 力量、肌肉量都進步較快 \r\n壞處：\r\n一星期需要練五六次 容易太累 需要安排好組數分配 訓練\r\n\r\n菜單 – 上下分法：上半身 – 下半身 – 休息 – 上半身 – 下半身 – 休息 \r\n好處： \r\n一星期只要練四天 頻率高，每個部位練到兩次。 \r\n壞處： \r\n一次可能會花比較久的時間。 比較難針對小肌群 \r\n訓練菜單 – 每日波動型練法：肌肥大日-爆發力日-肌力日 好處： \r\n健力三項力量大爆發 肌肉量成長算快 壞處： \r\n主要是練三項，難針對小肌群。 選好分法之後就是把你預設好的部位組數分配下去。', 1, '2020-04-27 10:32:21', '2020-04-29 17:08:08'),
(3, '減肥飲食教學大全', 'article_20200429041800.jpg', '幾個常見的減肥飲食法 \r\n一、間歇性斷食法 這種減肥飲食方式大概是20年前開始興起的，研究後發現對身體有非常多的好處，所以近年來越來越受歡迎普通人可以利用這種飲食來讓身體更健康，也可維持身材\r\n\r\n 二、碳循環飲食法 碳循環飲食 ( Carb Cycling diet )，也稱碳水循環法，是我個人認為最棒的飲食方式。易胖或是對醣類耐受度不好的人用這種碳水循環的飲食方式增肌或是減脂比較不會增加太多脂肪\r\n\r\n 三、生酮飲食 生酮飲食算是近期最熱門的飲食方式之一，70%的人拿來減肥，30%的人拿來顧身體健康 四、低醣飲食 ( 低碳飲食 ) 這個飲食法是把醣類攝取盡量降低的一種飲食方式簡單來講就是只吃菜肉蛋、不吃澱粉、甜食的一種飲食方式', 2, '2020-04-27 10:39:05', '2020-04-29 17:09:00'),
(4, '哪種減重飲食最能有效減重', 'article_20200429041944.jpg', '沒有計算熱量的狀況下，低醣比低脂有效減重 剛剛講的都是有在算熱量的 如果你不會算什麼主要營養素、熱量什麼的或是你就是不想算這些 那我會非常建議你用低醣的方式來減重 可以看到下方這個研究統整一樣是比較低醣或低脂 但是低醣組沒有限制他們要吃多少熱量，就放著他們去吃正確的食物 結果顯示出在一年內 沒有限制熱量攝取的條件下，低醣飲食比低脂飲食更能有效減重 主要就是歸功在低醣飲食是很飽的飲食方式，讓我們比較難去吃太多東西 主要營養素方面若要做個統整的話，我會建議大家： \r\n\r\n第一、不管哪種減重飲食方式，你蛋白質都要吃夠，可以幫助你減肥、防止復胖 \r\n\r\n第二、蔬菜要多吃 \r\n\r\n第三、不算熱量的人就吃低醣 \r\n\r\n第四、有胰島素阻礙的可以嘗試低醣飲食 \r\n\r\n第五、喜歡算營養素的可以嘗試碳循環飲食', 2, '2020-04-27 10:42:39', '2020-04-29 17:09:40'),
(5, '什麼是生酮飲食？', 'article_20200429042023.png', '生酮的意思是，讓身體可以產”生“、較多“酮”體的飲食方式，以待在穩定的營養性酮症(Nutritional Ketosis)為目標。 \r\n\r\n營養性酮症 在沒有攝取醣份的狀態下，由於大腦以及其他一些器官無法使用脂肪當作能量，所以肝臟會代謝掉脂肪，轉化成酮體。 而當酮體在血液中濃度增加，我們稱為酮症（Ketosis），而靠飲食所造成的酮症，我們稱為營養性酮症(Nutritional Ketosis)。 \r\n\r\n普通吃法過程中，身體也會製造出酮體，只是製造的機會不多，以及製造量不足以達到營養性酮症的濃度。 生酮飲食吃低醣、適中、蛋白高油就是為了要讓身體待在營養性酮症的時間長一點，讓血酮濃度高一點（代表脂肪燃燒），而確定身體再燃脂的效果。 \r\n\r\n進入穩定的酮症之後，就可以享有生酮飲食帶給身體的優點，像是改善荷爾蒙、食慾、抗氧化等等的，而減肥通常也是一個附帶的效果。', 3, '2020-04-27 10:50:27', '2020-04-29 17:10:31'),
(6, '生酮飲食應該要吃多少脂肪？', 'article_20200429042050.jpg', '生酮飲食與脂肪 \r\n生酮之所以叫做生酮，不是因為你各種食材吃幾 % 的比例而叫生酮，\r\n生酮是你的飲食讓你的身體能夠主要以酮體為能源才叫做生酮，無論你什麼營養攝取多少，只要你能以酮為主要能源，你就是生酮飲食，如我二姐，她吃低碳，但她酮體測量接近3，那麼她就算生酮，而不是看她吃了多少碳水而定，不要再說生酮不是不能吃碳水嗎？生酮蛋白質不是不能吃多嗎？ \r\n\r\n1.水在生酮裡面也是需要注意的一個重點，基本胰島素下降不綁水所以不用擔心水腫，但是由於排水常常導致鈉過低，鈉沒有補充足夠，身體擔心再喝水會再稀釋體液，所以身體會排斥喝水，如果不注意容易造成水份不足。\r\n\r\n 2.微量元素則是平常注意攝取全食物以及營養密度高的食物，深色蔬菜，基本不用太擔心。 \r\n\r\n3.蛋白質在生酮裡面無需攝取太多，所以一般都是攝取過量，很少有攝取不足的問題。', 3, '2020-04-27 10:55:36', '2020-04-29 17:11:17'),
(7, '2020年最新的減肥攻略大法', 'article_20200429042119.jpg', '減肥別再犯的幾個重點迷思 少吃多動的減肥迷思 少吃多動這句話其實是正確的，\r\n但是大部分的人都執行錯誤。 很多人會以為所有的東西都要少吃，所以就把熱量限制的很低，有點在吃超低熱量仙女餐的感覺 然後多動的部分，大家第一個想到的都是跑步、騎腳踏車等等的有氧運動，但其實這是非常不長久且很容易復胖的方式 主要是因為吃太少就是一個容易讓肌肉量流失的原因，再加上有氧訓練對於肌肉量增長沒什麼幫助，導致代謝整個下降太多可能你可以靠這個方式瘦個5公斤，但代謝下降的你，很容易就會復胖。', 4, '2020-04-27 11:00:53', '2020-04-29 17:11:51'),
(8, '減肥運動的完整攻略', 'article_20200429042200.jpg', '減肥期間的運動安排 常常會有人問我什麼是最有效的快速減肥運動 \r\n那再講減肥運動計畫的菜單安排之前，這邊首先要跟大家講一下重訓跟有氧，對於改變你的體態的幫助哪裡有不一樣重訓在長期維持好體態是很重要的，因為他可以增加你肌肉對胰島素敏感度，更多的肌肉量也可以提升你對醣的耐受度 但是重訓幫助短期減肥的效果大概佔了10%而已，\r\n所以不要想要用努力運動來蓋過很爛的飲食不要覺得你胸推多做一組就可以多吃一個甜甜圈，對我來講重訓在短期減肥，只是為了讓你肌肉量維持 換句話說你可以完全不重訓，跟我之前一樣整天打楓之谷，然後只靠飲食減了30公斤，只是肌肉量相對也掉了一堆而有氧運動是相反過來的效果，對長期保持好體態沒什麼太大的幫助 因為研究就顯示出，你跑越多，代謝就會下降越多，肌肉量也不容易長出來甚至變少，然後你突然不跑就會變胖回來 但是你短期內多做一點有氧運動，是對短期減肥是有幫助的', 4, '2020-04-27 11:04:17', '2020-04-29 17:12:13'),
(9, '練臀肌必看的女生重訓課表', 'article_20200429112859.jpg', '如何練出細腰與翹臀\r\n男生比起女生做重量訓練起來相較簡單，大概就是每個地方都要練一下，整體來講才不會哪裡太粗哪裡太細。而女生大部分想要的體態是腰線細、翹臀、腿不要太粗，所以為了達到這個目的，不能像男生一樣每個地方都平均練。\r\n\r\n女生腰要細的話背肌一定要多練，尤其是背闊肌被寬，視覺上腰看起來就細了。然後多做一些練臀動作把臀部練大也會讓腰看起來更細。所以千萬不要向網路上看到什麼猛操腹肌瘦肚子，或是去健身房在那邊扭轉腰之類的。雖然核心很重要，但是腹部你鍛鍊越多，腰就會越粗。要翹臀、腿又不要太粗就是要盡量挑動作。像是大家覺得深蹲是一個很有效的練臀動作，但其實深蹲比起臀舉大概只有40~45趴刺激臀部的效果，所以其實練臀動作有更好的選擇。', 1, '2020-04-29 17:28:58', '2020-04-29 17:28:58'),
(10, '身體對於咖啡因所產生的反應', 'article_20200429113101.jpg', '介紹咖啡對於身體的優點\r\n幫助減脂？\r\n應該很多人聽過以下說法，「喝咖啡能夠幫助燃燒脂肪」。這句話是有相當的科學證據的。\r\n\r\n一項研究發現攝取咖啡因的組別比起安慰劑組\r\n\r\n有將近兩倍的脂質代謝率(lipid turnover)、血液中游離脂肪酸增加(分解增加)和更好的生熱效應，能量支出也比安慰劑組多了13%左右。\r\n\r\n但在文章的最後作者也提到，只有24%的脂質是真的被氧化的，76%的則是被回收，重新儲存進脂肪細胞。\r\n\r\n白話文來說就是，喝咖啡可能可以稍微提升你身體對於脂肪的代謝能力，但如果你一樣沒有讓身體有所謂耗能的需求，也就是運動，也是對減脂沒有幫助的。', 2, '2020-04-29 17:31:00', '2020-04-29 17:31:00'),
(11, '重訓可用的生酮飲食｜循環式補碳生酮', 'article_20200429113439.jpg', '為什麼要補碳？\r\n生酮補碳是為了回復分解脂肪以及醣的酵素，因為生酮飲食“長久”下來幫助分解脂肪、醣的酵素會下降。回復幫助減肥的賀爾蒙。開心一下\r\n生酮補碳要補多久？\r\n24小時以上\r\n肝臟需要五小時來回復酵素，肌肉需要24小時，甚至如果你不常補碳的話，需要更久的時間。\r\n沒有運動的可能會花比較久的時間若是沒有把重訓為主的人只要知道以上這些就好\r\n\r\n補碳知識\r\n\r\n醣吸收每兩小時可以50克。\r\n在補碳前將肝糖濃度減到30後，肌肉可以吸收更多，補碳24小時可以到150mmol/kg\r\n建議熱量攝取為平日的1.5倍-2倍\r\n24小時總共要吃（體重 – 體脂肪）x10g的醣', 3, '2020-04-29 17:34:38', '2020-04-29 17:34:38'),
(12, '為什麼你不應該相信基礎代謝率？', 'article_20200429113625.jpg', '知道基礎代謝率怎麼來的嗎？\r\n這是1900年左右的東西啊！即使在當時準確，以當時人的生活活動量平均下去計算的才能適用，1900年的生活活動量跟現在得差上多少啊？\r\n光是20年前的生活便利性與現在比較呢？這東西要他媽的怎樣才能適用在現代人身上？\r\n所以為什麼這麼多人使用公式下去計算之後，結果卻是這樣的悲慘？\r\n一個理論開頭就錯了，後面也絕對都是錯誤的。\r\n基礎代謝這東西只能參考，具體還是要測量追蹤才能知道自己確切的數值大概在什麼地方，而且浮動的非常大，有人覺得自己一天只攝取900-1200卡實在是太少了，但是這樣就飽了，好害怕自己的代謝異常下降，我常常都覺得很好笑，你飽了是因為你的基礎代謝真的就是只有那可憐的900-1200卡就夠了。\r\n看到這裡應該就能知道為什麼我會反對使用基礎代謝率的公式下去計算自己的攝食量了吧？\r\n來！\r\n跟我大聲一起唸~\r\n去你媽的基礎代謝率！', 4, '2020-04-29 17:36:25', '2020-04-29 17:36:25');

-- --------------------------------------------------------

--
-- 資料表結構 `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL COMMENT '流水號',
  `categoryName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '類別名稱',
  `categoryParentId` int(11) DEFAULT 0 COMMENT '上層編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='類別資料表';

--
-- 傾印資料表的資料 `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryName`, `categoryParentId`, `created_at`, `updated_at`) VALUES
(1, 'mens', 0, '2020-04-24 10:21:38', '2020-04-24 10:21:38'),
(2, 'womens', 0, '2020-04-24 10:40:48', '2020-04-24 10:40:48'),
(3, 'food', 0, '2020-04-24 10:42:17', '2020-04-24 10:42:17'),
(4, 'cookie', 3, '2020-04-24 15:40:47', '2020-04-24 16:44:09'),
(6, 'protein', 3, '2020-04-27 13:04:43', '2020-04-27 13:04:43'),
(7, 'shirt', 1, '2020-04-27 13:04:59', '2020-04-27 13:04:59'),
(8, 'pants', 1, '2020-04-27 13:05:19', '2020-04-27 13:05:19');

-- --------------------------------------------------------

--
-- 資料表結構 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL COMMENT '流水號',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內容',
  `rating` tinyint(1) NOT NULL COMMENT '評分',
  `parentId` int(11) NOT NULL DEFAULT 0 COMMENT '上(父)層編號',
  `itemId` int(11) NOT NULL COMMENT '商品編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='評論';

-- --------------------------------------------------------

--
-- 資料表結構 `couch`
--

CREATE TABLE `couch` (
  `c_id` int(10) NOT NULL COMMENT '教練流水號',
  `c_username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '教練帳號',
  `c_pwd` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '教練密碼',
  `c_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '教練姓名',
  `c_img` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '教練照片路徑',
  `c_email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '教練信箱',
  `c_gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '教練性別',
  `c_phoneNumber` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '教練手機號碼',
  `c_birthday` date NOT NULL COMMENT '教練生日',
  `c_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '教練地址',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用者資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `coupon`
--

CREATE TABLE `coupon` (
  `couponID` int(11) NOT NULL COMMENT '優惠卷編號',
  `couponName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '優惠卷名稱',
  `couponMoney` int(11) NOT NULL COMMENT '優惠卷金額',
  `Remarks` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '備註',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='優惠卷資料表';

--
-- 傾印資料表的資料 `coupon`
--

INSERT INTO `coupon` (`couponID`, `couponName`, `couponMoney`, `Remarks`, `created_at`, `updated_at`) VALUES
(22, '全館折扣', 50, '2020年活動', '2020-04-24 16:16:35', '2020-04-27 10:49:53'),
(26, 'VIP折扣', 150, '2020年活動', '2020-04-27 10:44:19', '2020-04-27 10:46:00'),
(27, '三月禮金', 200, '2020年活動', '2020-04-27 10:45:39', '2020-04-27 10:45:39'),
(28, '母親節好禮', 200, '2020年活動', '2020-04-27 10:51:47', '2020-04-27 10:51:47'),
(30, '註冊禮金', 100, '2020年活動', '2020-04-27 11:24:21', '2020-04-27 11:24:21'),
(31, '滿額贈送', 100, '2020年活動', '2020-04-27 11:24:36', '2020-04-27 11:24:36');

-- --------------------------------------------------------

--
-- 資料表結構 `couponrecord`
--

CREATE TABLE `couponrecord` (
  `couponID` int(11) NOT NULL COMMENT '優惠卷編號',
  `userID` int(11) NOT NULL COMMENT '會員編號',
  `orderID` int(11) NOT NULL COMMENT '訂單編號',
  `orderMoney` int(11) NOT NULL COMMENT '原訂單金額',
  `couponMoney` int(11) NOT NULL COMMENT '優惠卷金額',
  `useTime` datetime NOT NULL COMMENT '使用時間',
  `useStatus` datetime NOT NULL COMMENT '使用狀態',
  `couponStartTime` datetime NOT NULL COMMENT '優惠開始時間',
  `couponEndTime` datetime NOT NULL COMMENT '優惠結束時間',
  `couponName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '優惠卷名稱',
  `created_at` datetime NOT NULL COMMENT '新增時間',
  `updated_at` datetime NOT NULL COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='優惠卷領取紀錄資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `courses`
--

CREATE TABLE `courses` (
  `coursesId` int(11) NOT NULL COMMENT '課程編號',
  `staffId` int(11) NOT NULL COMMENT '員工編號',
  `coursesCategoryId` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '課程類別ID',
  `coursesName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '課程名稱',
  `coursesImg` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '課程照片',
  `coursesContent` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '課程內容',
  `coursesHours` int(11) NOT NULL COMMENT '課程時數',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='課程資料表';

--
-- 傾印資料表的資料 `courses`
--

INSERT INTO `courses` (`coursesId`, `staffId`, `coursesCategoryId`, `coursesName`, `coursesImg`, `coursesContent`, `coursesHours`, `created_at`, `updated_at`) VALUES
(3, 0, '2', '階梯有氧', 'courses_20200424093307.jpg', '  階梯有氧運動具有高強度低衝擊的運動特性，階梯有氧運動與一般的有氧舞蹈最大的不同在於踏板的使用，藉由音樂的節奏達到流汗運動效果，運用階梯做有氧舞步變化，適當的音樂速度及正確的姿勢、且利用踏板高度的不', 2, '2020-04-23 16:06:44', '2020-04-23 16:06:44'),
(4, 0, '2', '活力有氧', 'courses_20200424093418.png', '活力有氧課程，從暖身開始，以入門有氧動作為基礎，用簡單及輕快的基礎舞步編串，帶您進入有氧舞蹈的奇妙世界；課程主要目的為強化心肺功能、加快新陳代謝，更可提升身體的協調性，隨著音樂感受著燃燒脂肪的快感，達', 1, '2020-04-23 16:24:42', '2020-04-23 16:24:42'),
(5, 0, '2', '全方位雕塑', 'courses_20200424093440.jpg', '以肌力訓練方式為基礎，在課堂中會運用各式抗阻器材，如啞鈴、瑜珈球、藥球、彈力繩、槓鈴或踏板並配合激揚的音樂來訓練到全身肌肉部位。', 1, '2020-04-23 16:57:31', '2020-04-23 16:57:31'),
(9, 0, '4', '熱瑜珈', 'courses_20200427103653.jpg', '1111', 2, '2020-04-27 16:36:53', '2020-04-27 16:36:53');

-- --------------------------------------------------------

--
-- 資料表結構 `coursescategory`
--

CREATE TABLE `coursescategory` (
  `coursesCategoryId` int(10) NOT NULL COMMENT '課程種類流水編號',
  `coursesCategoryName` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '課程種類名稱',
  `coursesCategoryParentId` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '課程種類上層編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `coursescategory`
--

INSERT INTO `coursescategory` (`coursesCategoryId`, `coursesCategoryName`, `coursesCategoryParentId`, `created_at`, `updated_at`) VALUES
(1, '全部課程', '0', '2020-04-24 16:00:35', '2020-05-01 06:45:32'),
(2, '心肺肌力訓練課程', '1', '2020-04-24 11:32:31', '2020-04-27 12:13:58'),
(3, '舞動舞蹈課程 ', '1', '2020-04-24 13:42:48', '2020-04-27 12:14:00'),
(4, '靜態伸展課程 ', '1', '2020-04-24 13:50:40', '2020-04-27 12:14:02');

-- --------------------------------------------------------

--
-- 資料表結構 `items`
--

CREATE TABLE `items` (
  `itemId` int(11) NOT NULL COMMENT '流水號',
  `itemName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名稱',
  `itemImg` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品照片路徑',
  `itemPrice` int(11) NOT NULL COMMENT '商品價格',
  `itemQty` tinyint(3) NOT NULL COMMENT '商品數量',
  `itemCategoryId` int(11) NOT NULL COMMENT '商品種類編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間',
  `itemType` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品類型',
  `imgURL` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '圖片網址',
  `englishName` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '英文名稱',
  `flavor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '口味',
  `englishFlavor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '英文口味'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品列表';

--
-- 傾印資料表的資料 `items`
--

INSERT INTO `items` (`itemId`, `itemName`, `itemImg`, `itemPrice`, `itemQty`, `itemCategoryId`, `created_at`, `updated_at`, `itemType`, `imgURL`, `englishName`, `flavor`, `englishFlavor`) VALUES
(401, '高蛋白曲奇餅乾', 'High Portein cookie White chocolate.png', 1400, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/PrRZFq8/High-Portein-cookie-White-chocolate.jpg', 'High Portein cookie ', '白巧克力味', 'White chocolate'),
(402, '高蛋白曲奇餅乾', 'High Portein cookie chocolate.png', 1400, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/5szWMtQ/High-Portein-cookie-chocolate.jpg', 'High Portein cookie ', '巧克力味', 'Chocolate'),
(403, '高蛋白曲奇餅乾', 'High Portein cookie Creamy.png', 1400, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/XSbZsJ4/High-Portein-cookie-Creamy.jpg', 'High Portein cookie ', '奶油口味', 'Creamy'),
(404, '高蛋白曲奇餅乾', 'High Portein cookie Rocky Road.png', 1400, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/0QpS1K6/High-Portein-cookie-Rocky-Road.jpg', 'High Portein cookie ', '岩石路布朗尼口味', 'Rocky Road'),
(405, '高蛋白曲奇餅乾', 'High Portein cookie Oatmeal grape.png', 1400, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/88Q8DrL/High-Portein-cookie-Oatmeal-grape.jpg', 'High Portein cookie ', '燕麥葡萄', 'Oatmeal grape'),
(406, '高蛋白曲奇餅乾', 'High Portein cookie Double chocolate.png', 1400, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/BcCCcD1/High-Portein-cookie-Double-chocolate.jpg', 'High Portein cookie ', '雙倍巧克力口味', 'Double chocolate'),
(407, '高蛋白布朗尼', 'High Portein Brownie chocolate.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/fq8ywXN/High-Portein-Brownie-chocolate.jpg', 'High Portein Brownie', '巧克力味', 'Chocolate'),
(408, '高蛋白布朗尼', 'High Portein Brownie white chocolate.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/S5J8BFy/High-Portein-Brownie-white-chocolate.jpg', 'High Portein Brownie', '白巧克力味', 'White chocolate'),
(409, '輕盈高蛋白曲奇餅乾', 'Light High Protein Cookies Cranberry White chocolate.png', 1400, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/QHGYN9w/Light-High-Protein-Cookies-Cranberry-White-chocolate.jpg', 'Light High Protein Cookies', '蔓越莓白巧克力口味', 'Cranberry White chocolate'),
(410, '輕盈高蛋白曲奇餅乾', 'Light High Protein Cookies Chocolate berry.png', 1400, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/P6np1xc/Light-High-Protein-Cookies-Chocolate-berry.jpg', 'Light High Protein Cookies', '黑巧克力莓果味', 'Chocolate berry'),
(411, '低卡優格穀物棒', 'Low Calorie Yogurt Bars Double chocolate.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/0CF2JkJ/Low-Calorie-Yogurt-Bars-Double-chocolate.jpg', 'Low Calorie Yogurt Bars', '雙倍巧克力口味', 'Double chocolate'),
(412, '低碳水蛋白脆米棒', 'Low-Carbon Water Protein Crispy Rice Stick Peanut.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/V26d1Tf/Low-Carbon-Water-Protein-Crispy-Rice-Stick-Peanut.jpg', 'Low Calorie Yogurt Bars', '花生醬味', 'Peanut'),
(413, '低碳水蛋白脆米棒', 'Low-Carbon Water Protein Crispy Rice Stick Chocolate Brownie.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/BwrKzhq/Low-Carbon-Water-Protein-Crispy-Rice-Stick-Chocolate-Brownie.jpg', 'Low Calorie Yogurt Bars', '巧克力布朗尼口味', 'Chocolate Brownie'),
(414, '純素低碳水蛋白脆米棒', 'Low carbon water protein bar Peanut.png', 1500, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/WyT3tJv/Low-carbon-water-protein-bar-Peanut.jpg', 'Low carbon water protein bar', '花生醬味', 'Peanut'),
(415, '純素低碳水蛋白脆米棒', 'Low carbon water protein bar chocolate.png', 1500, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/mTt4KGv/Low-carbon-water-protein-bar-chocolate.jpg', 'Low carbon water protein bar', '巧克力味', 'Chocolate'),
(416, '燕麥乳清蛋白棒', 'Oat Protein bar chocolate.png', 1200, 18, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/7r2QzPx/Oat-Protein-bar-chocolate.jpg', 'Oat Protein bar', '巧克力味', 'Chocolate'),
(417, '燕麥乳清蛋白棒', 'Oat Protein bar Raspberry.png', 1200, 18, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/vxZzLb6/Oat-Protein-bar-Raspberry.jpg', 'Oat Protein bar', '覆盆莓口味', 'Raspberry'),
(418, '燕麥乳清蛋白棒', 'Oat Protein bar Peanut Chocolate.png', 1200, 18, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/3kwLNVN/Oat-Protein-bar-Peanut-Chocolate.jpg', 'Oat Protein bar', '花生巧克力味', ' Peanut Chocolate'),
(419, '燕麥乳清蛋白棒', 'Oat Protein bar Salted Caramel.png', 1200, 18, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/tQrDzkF/Oat-Protein-bar-Salted-Caramel.jpg', 'Oat Protein bar', '鹹焦糖味', 'Salted Caramel'),
(420, '低卡高纖蛋白棒', 'Portein Light bar unflavoured.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/ZWMw0CJ/Portein-Light-bar-unflavoured.jpg', 'Portein Light bar', '原味', 'unflavoured'),
(421, '高蛋白營養棒', 'High protein nutrition bar chocolate coconut.png', 1200, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/M1x3375/High-protein-nutrition-bar-chocolate-coconut.jpg', 'High protein nutrition bar', '巧克力椰子味', 'chocolate coconut'),
(422, '高蛋白營養棒', 'High protein nutrition bar Chocolate.png', 1200, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/X57qTvj/High-protein-nutrition-bar-Chocolate.jpg', 'High protein nutrition bar', '巧克力味', 'Chocolate'),
(423, '高蛋白營養棒', 'High protein nutrition bar Vanilla Honey.png', 1200, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/NrRCgKP/High-protein-nutrition-bar-Vanilla-Honey.jpg', 'High protein nutrition bar', '香草蜂蜜口味', 'Vanilla Honey'),
(424, '高蛋白軟心餅乾', 'High-protein soft heart biscuits Double chocolate Caramel.png', 1500, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/sVtJcVH/High-protein-soft-heart-biscuits-Double-chocolate-Caramel.jpg', 'High-protein soft heart biscuits', '雙倍焦糖巧克力口味', 'Double chocolate Caramel'),
(425, '高蛋白烘焙餅乾', 'Protein baked cookie Chocolate.png', 100, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/Y3vkJJs/Protein-baked-cookie-Chocolate.jpg', 'Protein baked cookie', '巧克力味', 'Chocolate'),
(426, '多合一蛋白能量棒', 'All In One Protein energy bar chocolate.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/mJN0fyD/All-In-One-Protein-energy-bar-chocolate.jpg', 'All In One Protein energy bar', '巧克力味', 'Chocolate'),
(427, 'Pro Bar 蛋白能量棒', 'Pro Bar chocolate berry.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/Gx9CXZd/Pro-Bar-chocolate-berry.jpg', 'Pro Bar Protein Energy Bar', '黑巧克力莓果味', 'chocolate berry'),
(428, 'Pro Bar 蛋白能量棒', 'Pro Bar Vanilla Toffee.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/2vS5VZc/Pro-Bar-chocolate-Vanilla-Toffee.jpg', 'Pro Bar Protein Energy Bar', '太妃糖香草口味', 'Vanilla Toffee'),
(429, 'Pro Bar 蛋白能量棒', 'Pro Bar Caramel Hazelnut.png', 1000, 12, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/BGcVfH2/Pro-Bar-Caramel-Hazelnut.jpg', 'Pro Bar Protein Energy Bar', '焦糖榛子口味', 'Caramel Hazelnut'),
(430, '高蛋白布朗尼(1包)', 'High Portein Brownie chocolate single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/2c9ByDf/High-Portein-Brownie-chocolate-single.jpg', 'High Portein Brownie (single)', '巧克力味', 'Chocolate'),
(431, '高蛋白布朗尼(1包)', 'High Portein Brownie white chocolate single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/yYgtm9Y/High-Portein-Brownie-white-chocolate-single.jpg', 'High Portein Brownie (single)', '白巧克力味', 'White chocolate'),
(432, '高蛋白軟心餅乾(1包)', 'High-protein soft heart biscuits Double chocolate Caramel single.png', 150, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/vzTZqx8/High-protein-soft-heart-biscuits-Double-chocolate-Caramel-single.jpg', 'High-protein soft heart biscuits (single)', '雙倍焦糖巧克力口味', 'Double chocolate Caramel'),
(433, '低卡優格穀物棒(1包)', 'Low Calorie Yogurt Bars Double chocolate single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/wWFQMTz/Low-Calorie-Yogurt-Bars-Double-chocolate-single.jpg', 'Low Calorie Yogurt Bars (single)', '雙倍巧克力口味', 'Double chocolate'),
(434, '高蛋白營養棒(1包)', 'High protein nutrition bar chocolate coconut single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/BCdwgj8/High-protein-nutrition-bar-chocolate-coconut-single.jpg', 'High protein nutrition bar (single)', '巧克力椰子味', 'chocolate coconut'),
(435, '高蛋白營養棒(1包)', 'High protein nutrition bar Chocolate single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/7C530mv/High-protein-nutrition-bar-Chocolate-single.jpg', 'High protein nutrition bar (single)', '巧克力味', 'Chocolate'),
(436, '高蛋白營養棒(1包)', 'High protein nutrition bar Vanilla Honey single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/f1BzZgr/High-protein-nutrition-bar-Vanilla-Honey-single.jpg', 'High protein nutrition bar (single)', '香草蜂蜜口味', 'Vanilla Honey'),
(437, '高蛋白曲奇餅乾(1包)', 'High Portein cookie White chocolate single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/f4r8xnr/High-Portein-cookie-White-chocolate-single.jpg', 'High Portein cookie (single)', '白巧克力味', 'White chocolate'),
(438, '高蛋白曲奇餅乾(1包)', 'High Portein cookie chocolate single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/9nTdS04/High-Portein-cookie-chocolate-single.jpg', 'High Portein cookie (single)', '巧克力味', 'Chocolate'),
(439, '高蛋白曲奇餅乾(1包)', 'High Portein cookie Creamy single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/f4r8xnr/High-Portein-cookie-White-chocolate-single.jpg', 'High Portein cookie (single)', '奶油口味', 'Creamy'),
(440, '高蛋白曲奇餅乾(1包)', 'High Portein cookie Rocky Road single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/vP4jfm9/High-Portein-cookie-Rocky-Road-single.jpg', 'High Portein cookie (single)', '岩石路布朗尼口味', 'Rocky Road'),
(441, '高蛋白曲奇餅乾(1包)', 'High Portein cookie Oatmeal grape single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/ccB5j3f/High-Portein-cookie-Oatmeal-grape-single.jpg', 'High Portein cookie (single)', '燕麥葡萄', 'Oatmeal grape'),
(442, '高蛋白曲奇餅乾(1包)', 'High Portein cookie Double chocolate single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/Gx3zNDR/High-Portein-cookie-Double-chocolate-single.jpg', 'High Portein cookie (single)', '雙倍巧克力口味', 'Double chocolate'),
(443, 'Pro Bar 蛋白能量棒(1包)', 'Pro Bar chocolate berry single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/ChNrK65/Pro-Bar-chocolate-berry-single.jpg', 'Pro Bar Protein Energy Bar (single)', '黑巧克力莓果味', 'chocolate berry'),
(444, 'Pro Bar 蛋白能量棒(1包)', 'Pro Bar Vanilla Toffee single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/xGRtc9L/Pro-Bar-Vanilla-Toffee-single.jpg', 'Pro Bar Protein Energy Bar (single)', '太妃糖香草口味', 'Vanilla Toffee'),
(445, 'Pro Bar 蛋白能量棒(1包)', 'Pro Bar Caramel Hazelnut single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/WPPh2hC/Pro-Bar-Caramel-Hazelnut-single.jpg', 'Pro Bar Protein Energy Bar (single)', '焦糖榛子口味', 'Caramel Hazelnut'),
(446, '低碳水蛋白脆米棒(1包)', 'Low-Carbon Water Protein Crispy Rice Stick Chocolate Brownie single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/0BH5yHV/Low-Carbon-Water-Protein-Crispy-Rice-Stick-Chocolate-Brownie-single.jpg', 'Low Calorie Yogurt Bars (single)', '巧克力布朗尼口味', 'Chocolate Brownie'),
(447, '燕麥乳清蛋白棒(1包)', 'Oat Protein bar Raspberry single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/7Ynfbhr/Oat-Protein-bar-Raspberry-single.jpg', 'Oat Protein bar (single)', '覆盆莓口味', 'Raspberry'),
(448, '燕麥乳清蛋白棒(1包)', 'Oat Protein bar Peanut Chocolate single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/3RjY0Xv/Oat-Protein-bar-Peanut-Chocolate-single.jpg', 'Oat Protein bar (single)', '花生巧克力味', ' Peanut Chocolate'),
(449, '燕麥乳清蛋白棒(1包)', 'Oat Protein bar Salted Caramel single.png', 100, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/L1m5sX4/Oat-Protein-bar-Salted-Caramel-single.jpg', 'Oat Protein bar (single)', '鹹焦糖味', 'Salted Caramel'),
(450, '輕盈高蛋白曲奇餅乾(1包)', 'Light High Protein Cookies Cranberry White chocolate single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/2WJBRn3/Light-High-Protein-Cookies-Cranberry-White-chocolate-single.jpg', 'Light High Protein Cookies (single)', '蔓越莓白巧克力口味', 'Cranberry White chocolate'),
(451, '輕盈高蛋白曲奇餅乾(1包)', 'Light High Protein Cookies Chocolate berry single.png', 120, 1, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'cookie', 'https://i.ibb.co/HtTRZ0B/Light-High-Protein-Cookies-Chocolate-berry-single.jpg', 'Light High Protein Cookies (single)', '黑巧克力莓果味', 'Chocolate berry'),
(501, 'Impact 乳清蛋白粉 ', 'Impact whey Protein Roasted Tea.png', 1200, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/rwQmJtJ/Impact-whey-Protein-Roasted-Tea.jpg', 'Impact whey Protein', '焙茶口味', 'Roasted Tea'),
(502, 'Impact 乳清蛋白粉 ', 'Impact whey Protein Milk Tea.png', 1500, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/7XHPpBh/Impact-whey-Protein-Milk-Tea.jpg', 'Impact whey Protein', '英式奶茶口味', 'Milk Tea'),
(503, 'Impact 乳清蛋白粉 ', 'Impact whey Protein Hokkaido milk.png', 1200, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/3zCJ0cP/Impact-whey-Protein-Hokkaido-milk.jpg', 'Impact whey Protein', '北海道牛奶口味', 'Hokkaido milk'),
(504, 'Impact 乳清蛋白粉 ', 'Impact whey Protein Red Apple.png', 1200, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/tDj3ZyS/Impact-whey-Protein-Red-Apple.jpg', 'Impact whey Protein', '紅蘋果口味', 'Red Apple'),
(505, 'Impact 乳清蛋白粉 ', 'Impact whey Protein Chestnut milk.png', 1200, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/d5vJW7j/Impact-whey-Protein-Chestnut-milk.png', 'Impact whey Protein', '栗子奶茶口味', 'Chestnut milk'),
(506, 'Impact 乳清蛋白粉 ', 'Impact whey Protein Sakura milk.png', 1200, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/R3qqqmb/Impact-whey-Protein-Sakura-milk.jpg', 'Impact whey Protein', '櫻花奶茶口味', 'Sakura milk'),
(507, 'Impact 乳清蛋白粉 ', 'Impact whey Protein.png', 1300, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/Z6qpJ5s/Impact-whey-Protein.jpg', 'Impact whey Protein', '香蕉口味', 'Banana '),
(508, 'Impact 乳清蛋白粉 ', 'Impact whey Protein.png', 1300, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/Z6qpJ5s/Impact-whey-Protein.jpg', 'Impact whey Protein', '紅豆口味', 'Red beans'),
(509, 'Impact 乳清蛋白粉 ', 'Impact whey Protein.png', 1300, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/Z6qpJ5s/Impact-whey-Protein.jpg', 'Impact whey Protein', '水蜜桃冰茶口味', 'Paech ice tea'),
(510, 'Impact 乳清蛋白粉 ', 'Impact whey Protein.png', 1300, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/Z6qpJ5s/Impact-whey-Protein.jpg', 'Impact whey Protein', '肉桂丹麥酥皮口味', 'Cinnamon Danish Pastry'),
(511, 'Impact 菁英蛋白粉 ', 'Impact whey Protein Elite chocolate.png', 1500, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/wc8p4Qn/Impact-whey-Protein-Elite-chocolate.jpg', 'Impact whey Protein Elite', '巧克力味', 'Chocolate'),
(512, '透明分離乳清蛋白粉', 'Transparent Whey Protein Powder Paech ice tea.png', 1500, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/xz1LnHj/Transparent-Whey-Protein-Powder-Orange-Mango.jpg', 'Transparent Whey Protein', '水蜜桃冰茶口味', 'Paech ice tea'),
(513, '透明分離乳清蛋白粉', 'Transparent Whey Protein Powder Bitter leamon.png', 1500, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', ' https://i.ibb.co/RHKvXhh/Transparent-Whey-Protein-Powder-Paech-ice-tea.jpg', 'Transparent Whey Protein', '苦檸檬口味', 'Bitter lemon'),
(514, '透明分離乳清蛋白粉', 'Transparent Whey Protein Powder Orange Mango.png', 1500, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/mRPQ9Jw/Transparent-Whey-Protein-Powder-Bitter-leamon.jpg', 'Transparent Whey Protein', '橘子芒果口味', 'Orange Mango '),
(515, '透明分離乳清蛋白粉', 'Transparent Whey Protein Powder Rainbow Candy.png', 1500, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/M25SMb2/Transparent-Whey-Protein-Powder-Rainbow-Candy.jpg', 'Transparent Whey Protein', '彩虹糖口味', 'Rainbow Candy '),
(516, '透明分離乳清蛋白粉', 'Transparent Whey Protein Powder Mojito.png', 1500, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/j4tvVvJ/Transparent-Whey-Protein-Powder-Mojito.jpg', 'Transparent Whey Protein', '莫吉托口味', 'Mojito '),
(517, '純素透明分離蛋白粉', 'Vegan transparent protein isolate Strawberry.png', 1400, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/qsHXXM7/Vegan-transparent-protein-isolate-Strawberry.jpg', 'Vegan transparent protein isolate', '草莓口味', 'Strawberry'),
(518, '純素透明分離蛋白粉', 'Vegan transparent protein isolate Lemon.png', 1400, 1, 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'portein', 'https://i.ibb.co/RC6ct4T/Vegan-transparent-protein-isolate-Lemon.jpg', 'Vegan transparent protein isolate', '檸檬口味', 'Lemon'),
(520, 'a1', 'item_20200428094218.png', 358, 12, 8, '2020-04-28 15:42:18', '2020-04-28 15:42:18', '', '', '', '', ''),
(523, '', 'item_20200428114750.jpg', 0, 0, 1, '2020-04-28 17:47:50', '2020-04-28 17:47:50', '', '', '', '', ''),
(524, '', 'item_20200428114831.png', 0, 0, 1, '2020-04-28 17:48:31', '2020-04-28 17:48:31', '', '', '', '', ''),
(525, '', 'item_20200428115023.jpg', 0, 0, 1, '2020-04-28 17:50:23', '2020-04-28 17:50:23', '', '', '', '', ''),
(526, '', 'item_20200428115235.jpg', 0, 0, 1, '2020-04-28 17:52:35', '2020-04-28 17:52:35', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 資料表結構 `item_lists`
--

CREATE TABLE `item_lists` (
  `itemListId` int(11) NOT NULL COMMENT '流水號',
  `orderId` int(11) NOT NULL COMMENT '訂單編號',
  `itemId` int(11) NOT NULL COMMENT '商品編號',
  `checkPrice` int(11) NOT NULL COMMENT '結帳時單價',
  `checkQty` tinyint(3) NOT NULL COMMENT '結帳時數量',
  `checkSubtotal` int(11) NOT NULL COMMENT '結帳時小計',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='訂單中的商品列表';

--
-- 傾印資料表的資料 `item_lists`
--

INSERT INTO `item_lists` (`itemListId`, `orderId`, `itemId`, `checkPrice`, `checkQty`, `checkSubtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 100, 1, 100, '2020-04-27 14:34:46', '2020-04-27 14:34:46'),
(2, 2, 6, 100, 1, 100, '2020-04-27 14:34:57', '2020-04-27 14:34:57'),
(3, 3, 7, 10022, 1, 10022, '2020-04-27 14:35:11', '2020-04-27 14:35:11'),
(4, 4, 9, 12335, 1, 12335, '2020-04-27 17:02:35', '2020-04-27 17:02:35'),
(5, 5, 9, 12335, 1, 12335, '2020-04-27 18:11:59', '2020-04-27 18:11:59'),
(6, 6, 9, 12335, 1, 12335, '2020-04-28 10:00:02', '2020-04-28 10:00:02'),
(7, 7, 401, 1400, 1, 1400, '2020-04-29 14:10:49', '2020-04-29 14:10:49'),
(8, 8, 403, 1400, 2, 2800, '2020-04-29 14:11:02', '2020-04-29 14:11:02'),
(9, 10, 402, 1400, 1, 1400, '2020-05-01 01:17:27', '2020-05-01 01:17:27'),
(10, 11, 402, 1400, 1, 1400, '2020-05-01 01:48:12', '2020-05-01 01:48:12'),
(11, 11, 402, 1400, 1, 1400, '2020-05-01 01:48:12', '2020-05-01 01:48:12'),
(12, 11, 402, 1400, 1, 1400, '2020-05-01 01:48:12', '2020-05-01 01:48:12'),
(13, 12, 402, 1400, 1, 1400, '2020-05-01 02:07:00', '2020-05-01 02:07:00'),
(14, 14, 402, 1400, 1, 1400, '2020-05-01 02:09:59', '2020-05-01 02:09:59'),
(15, 15, 402, 1400, 1, 1400, '2020-05-01 02:11:43', '2020-05-01 02:11:43'),
(16, 16, 403, 1400, 1, 1400, '2020-05-01 02:14:11', '2020-05-01 02:14:11'),
(17, 17, 403, 1400, 1, 1400, '2020-05-01 02:15:02', '2020-05-01 02:15:02'),
(18, 0, 403, 1400, 1, 1400, '2020-05-01 02:18:32', '2020-05-01 02:18:32'),
(19, 18, 403, 1400, 1, 1400, '2020-05-01 02:18:40', '2020-05-01 02:18:40'),
(20, 19, 403, 1400, 1, 1400, '2020-05-01 02:19:14', '2020-05-01 02:19:14'),
(21, 20, 403, 1400, 1, 1400, '2020-05-01 02:27:05', '2020-05-01 02:27:05');

-- --------------------------------------------------------

--
-- 資料表結構 `multiple_images`
--

CREATE TABLE `multiple_images` (
  `multipleImageId` int(11) NOT NULL COMMENT '流水號',
  `multipleImageImg` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '圖片名稱',
  `itemId` int(11) NOT NULL COMMENT '商品編號',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品圖片';

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL COMMENT '流水號',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者帳號',
  `paymentTypeId` int(11) NOT NULL COMMENT '付款方式',
  `itemName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checkPrice` int(50) NOT NULL,
  `checkQty` int(50) NOT NULL,
  `checkSubtotal` int(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='結帳資料表';

--
-- 傾印資料表的資料 `orders`
--

INSERT INTO `orders` (`orderId`, `username`, `paymentTypeId`, `itemName`, `categoryName`, `checkPrice`, `checkQty`, `checkSubtotal`, `created_at`, `updated_at`) VALUES
(19, 'admin', 1, '3123', 'cooki313', 12321, 3123, 13123, '2020-05-01 02:19:14', '2020-05-01 02:25:12'),
(20, 'admin', 1, '高蛋白曲奇餅乾', 'cookie', 123, 123, 123, '2020-05-01 02:27:05', '2020-05-01 02:35:43');

-- --------------------------------------------------------

--
-- 資料表結構 `payment_types`
--

CREATE TABLE `payment_types` (
  `paymentTypeId` int(11) NOT NULL COMMENT '流水號',
  `paymentTypeName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '付款方式名稱',
  `paymentTypeImg` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '付款方式圖片名稱',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='付款方式';

--
-- 傾印資料表的資料 `payment_types`
--

INSERT INTO `payment_types` (`paymentTypeId`, `paymentTypeName`, `paymentTypeImg`, `created_at`, `updated_at`) VALUES
(1, 'Google pay', 'payment_type_20200428043038.png', '2020-04-27 14:33:34', '2020-04-28 10:30:37');

-- --------------------------------------------------------

--
-- 資料表結構 `staff`
--

CREATE TABLE `staff` (
  `staffId` int(11) NOT NULL COMMENT '員工編號',
  `staffName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工帳號',
  `staffPwd` char(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工密碼',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工姓名',
  `staffgender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '員工性別',
  `staffphone` int(11) NOT NULL COMMENT '員工手機號',
  `created_at` datetime NOT NULL COMMENT '新增時間',
  `updated_at` datetime NOT NULL COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='教練資料表';

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL COMMENT '使用者流水號',
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者名稱',
  `pwd` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者密碼',
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者姓名',
  `usernickname` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者暱稱',
  `useremail` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者信箱',
  `gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者性別',
  `phoneNumber` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者手機號碼',
  `birthday` date NOT NULL COMMENT '使用者生日',
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '使用者地址',
  `isActivated` tinyint(1) NOT NULL DEFAULT 0 COMMENT '開通狀況',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '新增時間',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用者資料表';

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `pwd`, `name`, `usernickname`, `useremail`, `gender`, `phoneNumber`, `birthday`, `address`, `isActivated`, `created_at`, `updated_at`) VALUES
(1, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '123', '', '', '男', '123', '0000-00-00', '123', 0, '2020-04-24 11:08:55', '2020-04-24 11:08:55'),
(2, 'test2', '109f4b3c50d7b0df729d299bc6f8e9ef9066971f', 'test2', 'test2', 'test2', '男', 'test2', '0000-00-00', 'test2', 0, '2020-04-27 12:46:54', '2020-04-27 12:46:54'),
(3, 'test3', '3ebfa301dc59196f18593c45e519287a23297589', 'test3', 'test3', 'test3', '男', 'test3', '2020-04-10', 'test3', 0, '2020-04-27 12:47:33', '2020-04-27 12:47:33');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 資料表索引 `articlecategories`
--
ALTER TABLE `articlecategories`
  ADD PRIMARY KEY (`articleCategoryId`);

--
-- 資料表索引 `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`articleId`);

--
-- 資料表索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- 資料表索引 `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `couch`
--
ALTER TABLE `couch`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `username` (`c_username`);

--
-- 資料表索引 `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`couponID`),
  ADD KEY `couponID` (`couponID`,`couponName`,`couponMoney`,`Remarks`,`created_at`,`updated_at`);

--
-- 資料表索引 `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`coursesId`);

--
-- 資料表索引 `coursescategory`
--
ALTER TABLE `coursescategory`
  ADD PRIMARY KEY (`coursesCategoryId`);

--
-- 資料表索引 `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemId`);

--
-- 資料表索引 `item_lists`
--
ALTER TABLE `item_lists`
  ADD PRIMARY KEY (`itemListId`);

--
-- 資料表索引 `multiple_images`
--
ALTER TABLE `multiple_images`
  ADD PRIMARY KEY (`multipleImageId`);

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- 資料表索引 `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`paymentTypeId`);

--
-- 資料表索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffId`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `articlecategories`
--
ALTER TABLE `articlecategories`
  MODIFY `articleCategoryId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `articles`
--
ALTER TABLE `articles`
  MODIFY `articleId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `couch`
--
ALTER TABLE `couch`
  MODIFY `c_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '教練流水號';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coupon`
--
ALTER TABLE `coupon`
  MODIFY `couponID` int(11) NOT NULL AUTO_INCREMENT COMMENT '優惠卷編號', AUTO_INCREMENT=32;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `courses`
--
ALTER TABLE `courses`
  MODIFY `coursesId` int(11) NOT NULL AUTO_INCREMENT COMMENT '課程編號', AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coursescategory`
--
ALTER TABLE `coursescategory`
  MODIFY `coursesCategoryId` int(10) NOT NULL AUTO_INCREMENT COMMENT '課程種類流水編號', AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `items`
--
ALTER TABLE `items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=528;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `item_lists`
--
ALTER TABLE `item_lists`
  MODIFY `itemListId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=22;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `multiple_images`
--
ALTER TABLE `multiple_images`
  MODIFY `multipleImageId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=21;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `paymentTypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水號', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '使用者流水號', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
