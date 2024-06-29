-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-02-2024 a las 11:05:18
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tiendaonline`
--
CREATE DATABASE IF NOT EXISTS `tiendaonline` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tiendaonline`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `id_autor` int(11) NOT NULL,
  `nombreAutor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id_autor`, `nombreAutor`) VALUES
(1, 'Carlos Ruiz Zafón'),
(2, 'Rebecca Yarros'),
(3, 'Lauren Roberts'),
(4, 'Jennifer L. Armentrout'),
(5, 'Colleen Hoover'),
(6, 'Stephanie Garber'),
(7, 'Markus Zusak'),
(8, 'Hanya Yanagihara'),
(9, 'James Clear'),
(10, 'Sarah J. Maas'),
(11, 'Matt Haig'),
(12, 'Erin Doom'),
(13, 'Jessa Hastings'),
(14, 'Inma Rubiales'),
(15, 'Andrea Longarela'),
(16, 'Stephen King'),
(17, 'Laura Gallego'),
(18, 'Elena Armas'),
(19, 'Shelby Mahurin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombreCategoria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombreCategoria`) VALUES
(1, 'Juvenil'),
(2, 'Más de 15 años'),
(3, 'Fantasía y magia'),
(4, 'Libros románticos y de amor'),
(5, 'Literatura'),
(6, 'Novela Contemporánea'),
(7, 'Narrativa Española'),
(8, 'Narrativa extranjera'),
(9, 'Novela romántica y erótica'),
(10, 'Novela romántica'),
(11, 'Narrativa en bolsillo'),
(12, 'Narrativa extranjera del XIX a'),
(13, 'Autoayuda y Espiritualidad'),
(14, 'Autoayuda'),
(15, 'Libros románticos y de amor'),
(16, 'Más de 13 años'),
(17, 'Novela negra'),
(18, 'Novela de terror'),
(19, 'Misterio y terror');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesta`
--

CREATE TABLE `cesta` (
  `id_cesta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cesta`
--

INSERT INTO `cesta` (`id_cesta`, `id_usuario`, `fecha_creacion`, `fecha_modificacion`) VALUES
(7, 7, '2024-02-18 09:42:41', '2024-02-18 09:42:41'),
(8, 8, '2024-02-18 20:09:43', '2024-02-18 20:09:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `estado_libro` set('Reservado','Comprado') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_libro`, `estado_libro`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 1, 'Comprado', 1, 22.90, 22.90),
(2, 1, 2, 'Reservado', 1, 23.90, 23.90),
(3, 8, 19, 'Reservado', 3, 21.95, 65.85),
(4, 8, 7, 'Comprado', 5, 20.50, 102.50),
(5, 8, 27, 'Comprado', 1, 23.90, 23.90),
(6, 8, 28, 'Comprado', 1, 23.90, 23.90),
(7, 8, 17, 'Comprado', 1, 24.90, 24.90),
(8, 8, 16, 'Comprado', 2, 21.90, 43.80),
(9, 9, 2, 'Comprado', 1, 23.90, 23.90);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id_favoritos` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `sinopsis` text NOT NULL,
  `numero_paginas` int(11) NOT NULL,
  `idioma` varchar(30) NOT NULL,
  `editorial` varchar(30) NOT NULL,
  `isbn` varchar(40) NOT NULL,
  `fecha_lanzamiento` date NOT NULL,
  `alto` int(11) NOT NULL,
  `ancho` int(11) NOT NULL,
  `encuadernacion` varchar(30) NOT NULL,
  `id_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_libro`, `titulo`, `precio`, `imagen`, `puntuacion`, `sinopsis`, `numero_paginas`, `idioma`, `editorial`, `isbn`, `fecha_lanzamiento`, `alto`, `ancho`, `encuadernacion`, `id_stock`) VALUES
(1, 'Alas de Sangre', 22.90, 'AlasDeSangre', 5, 'Violet Sorrengail creía que se uniría al Cuadrante de los Escribas para vivir una vida tranquila, sin embargo, por órdenes de su madre, debe unirse a los miles de candidatos que, en el Colegio de Guerra de Basgiath, luchan por formar parte de la élite de Navarre: el Cuadrante de los Jinetes de dragones.\r\n\r\n\r\nCuando eres más pequeña y frágil que los demás tu vida corre peligro, porque los dragones no se vinculan con humanos débiles. Además, con más jinetes que dragones disponibles, muchos la matarían con tal de mejorar sus probabilidades de éxito; y hay otros, como el despiadado Xaden Riorson, el líder de ala más poderoso del Cuadrante de Jinetes, que la asesinarían simplemente por ser la hija de la comandante general. Para sobrevivir, necesitará aprovechar al máximo todo su ingenio. Mientras  la guerra se torna más letal Violet sospecha que los líderes de Navarre esconden un terrible secreto...', 736, 'Castellano', 'Editorial Planeta', '9788408279990', '2023-11-15', 23, 15, 'Tapa dura', 1),
(2, 'Alas de hierro', 23.90, 'AlasDeHierro', 0, 'Todos esperaban que Violet Sorrengail muriera durante su primer año en el Colegio de Guerra Basgiath, incluso ella misma. Pero la Trilla fue tan solo la primera de una serie de pruebas imposibles destinadas a deshacerse de los indignos y los desafortunados.\r\n\r\nAhora comienza el verdadero entrenamiento, y Violet no sabe cómo logrará superarlo. No solo porque es brutal y agotador o porque está diseñado para llevar al límite el umbral del dolor de los jinetes, sino porque el nuevo vicecomandante está empeñado en demostrarle lo débil que es, a menos que traicione al hombre al que ama. La voluntad de sobrevivir no será suficiente este año, porque Violet conoce el secreto que se oculta entre los muros del colegio, y nada, ni siquiera el fuego de dragón, será suficiente para salvarlos.', 896, 'Castellano', 'Editorial Planeta', '9788408284550', '2024-02-21', 23, 15, 'Tapa dura', 2),
(3, 'Powerless', 20.85, 'Powerless', 3, 'Solo lo extraordinario pertenece al reino de Ilya: los excepcionales, los poderosos, los elites.\r\n\r\n \r\nAquellos que nacieron vulgares son solo eso: vulgares. Y cuando el rey decreta que todos los vulgares serán eliminados para preservar su sociedad de elite, carecer de poder se vuelve un crimen, convirtiendo a Paedyn Gray en una criminal por destino y en una ladrona por necesidad. Se hace pasar por psíquica en la ciudad real, pasando desapercibida para seguir viva y fuera de peligro.\r\n\r\n \r\nCuando Paedyn inesperadamente salva a uno de los príncipes de Ilya, se ve arrojada a las Pruebas de la Purga. La brutal competición existe para exhibir los poderes de los elites, algo de lo que Paedyn carece. Si la Purga y sus rivales no la matan, lo hará el príncipe cuando descubra lo que ella es en realidad...', 600, 'Castellano', 'Alfaguara', '9788419688361', '2024-02-08', 22, 15, 'Tapa blanda', 3),
(4, 'De Sangre y Cenizas', 19.95, 'DeSangreYCenizas', 5, 'Apasionante y con una acción trepidante, De sangre y ceniza es una fantasía sexy, adictiva e inesperada, perfecta para los seguidores de Sarah J. Maas y Laura Thalassa. Una Doncella… Elegida desde su nacimiento para dar comienzo a una nueva era, la vida de Poppy nunca le ha pertenecido. La vida de la Doncella es solitaria. Jamás la tocarán. Jamás la mirarán. Jamás le hablarán. Jamás sentirá placer. Mientras espera al día de su Ascensión, preferiría estar con los guardias luchando contra el mal que se llevó a su familia que preparándose para que los dioses la encuentren lo bastante digna. Pero la elección nunca ha sido suya. Un deber… El futuro del reino entero recae sobre los hombros de Poppy, algo que ni siquiera está demasiado segura de querer para ella. Porque una Doncella tiene corazón. Y alma. Y deseo. Y cuando Hawke, un guardia de ojos dorados que ha jurado asegurar su Ascensión, entra en su vida, el destino y el deber se entremezclan con el deseo y la necesidad. Él incita su ira, hace que se cuestione todo aquello en lo que cree y la tienta con lo prohibido. Un reino… Abandonado por los dioses y temido por los mortales, un reino caído está surgiendo de nuevo, decidido a recuperar lo que cree que es suyo mediante la violencia y la venganza. Y a medida que la sombra de los malditos se acerca, la línea entre lo prohibido y lo correcto se difumina. Poppy no solo está a punto de perder el corazón y ser considerada indigna por los dioses, sino que también está a punto de perder la vida cuando los ensangrentados hilos que mantienen unido su mundo empiezan a deshilacharse.', 672, 'Castellano', 'Puck', '9788417854317', '2021-10-05', 21, 14, 'Tapa blanda', 4),
(5, 'Un Reino de Carne y Fuego', 21.50, 'UnReinoDeCarneYFuego', 5, '¿Es el amor más fuerte que la venganza?Una traición.Todo lo que ha creído Poppy jamás es mentira, incluido el hombre del que se estaba enamorando. Rodeada de pronto por gente que la ve como un símbolo de un reino monstruoso, apenas sabe quién es sin el velo de la Doncella. Pero lo que sí sabe es que nada es tan peligroso para ella como él. El Señor Oscuro. El príncipe de Atlantia. Quiere que ella se enfrente a él, y esa es una orden que está más que contenta de obedecer. Puede que la haya secuestrado, pero jamás la tendrá.Una elección.A Casteel Da\'Neer se le conoce por muchos nombres y muchas caras. Sus mentiras son tan seductoras como sus manos. Sus verdades tan sensuales como su mordisco. Poppy sabe bien que no debe confiar en él. La necesita viva, sana e intacta para lograr sus objetivos. Pero él también es la única vía para que ella consiga lo que quiere: encontrar a su hermano Ian y comprobar con sus propios ojos si se ha convertido en un Ascendido desalmado. Trabajar con Casteel en lugar de contra él presenta sus propios riesgos. Él todavía la tienta con cada respiración, le ofrece todo lo que ha querido jamás. Casteel tiene planes para ella. Unos planes que podrían exponerla a un placer inimaginable y un dolor insondable. Planes que la obligarían a mirar más allá de todo lo que creía saber sobre sí misma. Y sobre él. Planes que podrían enlazar sus vidas de maneras inesperadas para las que ninguno de los dos reinos está preparado. Y ella es demasiado imprudente, está demasiado hambrienta, para resistirse a la tentación.Un secreto.Sin embargo, el malestar ha crecido en Atlantia mientras esperan el regreso de su príncipe. Los rumores de guerra se están extendiendo y Poppy está en el mismo centro de todo ello. El rey quiere utilizarla para enviar un mensaje. Los Descendentes quieren verla muerta. Los wolven se están volviendo más impredecibles. Y a medida que sus habilidades para percibir el dolor y las emociones comienzan a aumentar y fortalecerse, los atlantianos empiezan a temerla. Hay secretos oscuros en juego, secretos llenos de los pecados manchados de sangre de dos reinos que harían cualquier cosa por mantener la verdad oculta. Pero cuando la tierra empieza a temblar y los cielos empiezan a sangrar, puede que ya sea demasiado tarde.', 800, 'Castellano', 'Puck', '9788417854362', '2022-02-08', 21, 14, 'Tapa blanda', 5),
(6, 'Una Corona de Huesos Dorados', 21.50, 'UnaCoronaDeHuesosDorados', 5, 'Inclínate ante tu reina o sangra ante ella… De la autora superventas del New York Times Jennifer L. Armentrout llega el tercer libro de su saga De sangre y cenizas. Ha sido la víctima y la superviviente… Poppy jamás soñó que encontraría el amor que ha encontrado con el príncipe Casteel. Le gustaría disfrutar de su felicidad, pero primero deben liberar al hermano de Casteel y encontrar al suyo. Es una misión peligrosa y una de enormes consecuencias con las que ninguno de los dos había soñado. Porque Poppy es la Elegida, la Bendecida. La verdadera regente de Atlantia. Lleva en su interior la sangre del rey de los dioses. Por derecho propio, la corona y el reino son suyos. La enemiga y la guerrera… Lo único que Poppy siempre ha querido es controlar su propia vida, no las vidas de los demás, pero ahora debe elegir entre renunciar a su derecho de nacimiento o ceñirse la corona dorada y convertirse en la Reina de Carne y Fuego. Pero cuando los oscuros pecados del reino y sus secretos empapados en sangre por fin salen a la luz, un poder largo tiempo olvidado surge para convertirse en una verdadera amenaza. Y no se detendrá ante nada para asegurarse de que la corona jamás descanse sobre la cabeza de Poppy. Una amante y un corazón gemelo… Pero la mayor amenaza para ellos y para Atlantia es la que aguarda en el lejano oeste, donde la Reina de Sangre y Cenizas tiene sus propios planes, unos que lleva cientos de años esperando a cumplir. Poppy y Casteel deben plantearse lo imposible: viajar a las Tierras de los Dioses y despertar al rey en persona. Y a medida que secretos estremecedores y las traiciones más crueles salen a la luz, y emergen enemigos que amenazan todas las cosas por las que han luchado, Poppy y Casteel descubrirán lo lejos que están dispuestos a ir por su gente… y el uno por el otro.', 800, 'Castellano', 'Puck', '9788417854324', '2022-05-03', 21, 14, 'Tapa blanda', 6),
(7, 'Un Fuego en la Carne', 20.50, 'unfuegoenlacarne', 2, 'Cuando, tras una sorprendente traición, Sera y el seductor gobernante de las Tierras Umbrías (del que está locamente enamorada) acaban cautivos del falso Rey de los Dioses, solo hay una cosa que puede liberar a Nyktos y evitar que las fuerzas de las Tierras Umbrías invadan Dalos y desaten una guerra entre Primigenios.\r\n\r\n\r\nSin embargo, convencer a Kolis no será fácil. Mientras que su Retornado predilecto insiste en que Sera no es más que una mentira, la naturaleza errática de Kolis y su retorcido sentido del honor la dejan completamente descolocada; y nada podría haberla preparado para la crueldad de su corte ni para las impactantes verdades reveladas. Tales descubrimientos no solo ponen patas arriba todo cuanto Sera creía acerca de su deber y de la creación de los mundos, sino que también ponen en entredicho cuál es la verdadera amenaza. No obstante, sobrevivir a Kolis es solo una parte de la  batalla. La Ascensión se acerca, y a Sera se le agota el tiempo.\r\n\r\n\r\nPero Nyktos hará cualquier cosa por evitar que Sera muera y por darle la vida que se merece. Se arriesgará incluso a que se produzca la completa destrucción de los mundos, porque eso es justo lo que sucederá si él no Asciende como el Primigenio de la Vida. Aun así, puede que sus destinos no estén en sus manos. Sin embargo, existe una hebra inesperada; impredecible, desconocida y no escrita. Lo único más poderoso que los Hados.', 768, 'Castellano', 'Puck', '9788419252524', '2024-02-06', 21, 14, 'Tapa blanda', 7),
(8, 'Un Alma de Ceniza y Sangre', 21.50, 'unalmadecenizaysangre', 4, 'La Reina de Carne y Fuego se ha convertido en la Primigenia deáSangre y Hueso, la verdadera Primigenia de la Vida y la Muerte.áY la batalla que Casteel, Poppy y sus aliados han estado librandoásolo acaba de empezar. Los dioses se están despertando por todoáIliseeum y en el mundo mortal, preparándose para la guerra queáse avecina.\r\n\r\nCas debe enfrentarse a una posibilidad muy real: las extremasáe inesperadas consecuencias de aquello en lo que Poppy se estááconvirtiendo podrían arrebatársela. Sin embargo, Cas recibe unáconsejo al que planea aferrarse mientras espera a que los preciososáojos de su amada vuelvan a abrirse: \"Habla con ella\".\r\n\r\nAsí que eso hace. Le recuerda a Poppy cómo empezó su viaje juntosáy, en el proceso, revela cosas sobre sí mismo que solo Kieranáconoce. No obstante, es imposible saber que encontrará Poppy aládespertar y en que medida habrán cambiado el mundo y Cas cuandoálo haga.', 768, 'Castellano', 'Puck', '9788419252487', '2023-11-14', 21, 14, 'Tapa blanda', 8),
(9, 'Cazadora de Hadas', 18.00, 'cazadoradehadas', 5, 'Las cosas están a punto de ponerse muy complicadas en Nueva Orleans.\r\n\r\nIvy Morgan no es una universitaria cualquiera, ni su vida es tan tranquila como podría ser la de una chica de su edad. Ella pertenece a la Orden, una organización secreta encargada de combatir hadas y otras criaturas diabólicas que se mueven por el Barrio Frances de Nueva Orleans. Cuatro años atrás, esas criaturas le arrebataron a las personas que amaba. Y desde entonces no puede permitirse querer a nadie. En un trabajo como el suyo los vínculos emocionales están prohibidos.\r\n\r\nEntonces aparece Ren Owens, con sus ojos verdes y su metro noventa de tentación, a desestabilizar las barreras que ella misma se había impuesto. Y es que Ren es la última persona que Ivy necesita en su vida. Bajar la guardia con el es tan peligroso como ir a la caza de las hadas infernales que asolan las calles.\r\n\r\nIvy necesita algo más que las exigencias de su deber, pero ¿valdrá la pena abrir su corazón? ¿O quizás el hombre, que reclama su alma y su corazón, podría causarle más daño incluso que los seres antiguos que amenazan la ciudad?', 384, 'Castellano', 'Titania', '9788417421915', '2023-01-24', 23, 15, 'Tapa blanda', 9),
(10, 'Verity', 19.90, 'verity', 5, 'Lowen Ashleigh recibe un encargo que le cambiará la vida: Jeremy, el flamante marido de Verity Crawford, una de las autoras más importantes del momento, la contrata para terminar la serie de libros en la que trabajaba su mujer antes de sufrir un grave accidente que la ha dejado en coma. Cuando Lowen se instala en la mansión del matrimonio para poder trabajar con los materiales de Verity, descubre una autobiografía escondida en la que Verity hace confesiones escalofriantes. Lowen decide ocultarle el manuscrito a Jeremy, pero a medida que sus sentimientos por él comienzan a intensificarse, se da cuenta que ella podría beneficiarse si Jeremy leyera las palabras de su mujer.', 416, 'Castellano', 'Editorial Planeta', '9788408269755', '2023-03-08', 23, 15, 'Tapa dura', 10),
(11, 'Romper el Circulo', 18.90, 'romperelcirculo', 4, 'El gran fenómeno de TikTok.\r\nColleen Hoover te romperá el corazón.\r\nA veces, quien más te quiere es quién más daño te hace.\r\n\r\nLily no siempre lo ha tenido fácil. Por eso, su idílica relación con un magnífico neurocirujano llamado Ryle Kincaid, parece demasiado buena para ser verdad. Cuando Atlas, su primer amor, reaparece repentinamente y Ryle comienza a mostrar su verdadera cara, todo lo que Lily ha construido con él se ve amenazado. ', 400, 'Castellano', 'Editorial Planeta', '9788408258360', '2022-05-04', 23, 15, 'Tapa dura', 10),
(12, 'No Te Olvidaré', 18.90, 'noteolvidare', 5, 'Después de pasar cinco años en la cárcel por el trágico error que costó la vida de su gran amor Scott, Kenna Rowan regresa a casa con un único deseo: abrazar a su hija Diem, de cuatro años, que vive con los padres de Scott y a la que no ha visto desde que nació.\r\n\r\n \r\nLa única persona que no le ha cerrado la puerta por completo es Ledger Ward, dueño del bar local y uno de los pocos vínculos que le quedan con Diem. Pero ella sabe que si alguien descubre que Ledger se está convirtiendo lentamente en una parte importante de su vida, crece el riesgo de no recuperar a su hija. Kenna deberá encontrar una manera de reparar los errores de su pasado si quiere construir un nuevo futuro con Ledger.', 416, 'Castellano', 'Editorial Planeta', '9788408277170', '2023-08-30', 23, 15, 'Tapa dura', 12),
(13, 'La Balada de Nunca Jamás', 21.50, 'labaldadenuncajamas', 5, 'Después de la traición de Jacks, el Príncipe de Corazones, Evangeline Fox se promete que jamás volverá a confiar en él. Ahora que ha descubierto su propia magia, cree que puede usarla para recuperar el final feliz que Jacks le arrebató.\r\n\r\n\r\nPero cuando se descubre una nueva y aterradora maldición, Evangeline vuelve a verse abocada a una frágil asociación con el Príncipe de Corazones. Sin embargo, las reglas han cambiado esta vez. Jacks no es el único con el que debe tener cuidado. De hecho, podría ser el único en quien puede confiar, a pesar de su deseo de despreciarlo.\r\n\r\n\r\nHaciendo estragos en la vida de Evangeline, en lugar de un hechizo de amor, hay un encantamiento mortal. Para romperlo, Evangeline y Jacks tendrán que batallar con viejos amigos, nuevos enemigos y una magia que juega con las mentes y los corazones. Evangeline siempre ha confiado en su corazón, pero esta vez no está segura de poder hacerlo.', 416, 'Castellano', 'Puck', '9788417854928', '2023-02-01', 21, 14, 'Tapa blanda', 13),
(14, 'Érase Una Vez un Corazón Roto', 17.50, 'eraseunavezuncorazonroto', 5, 'Recuerda. nunca hagas un trato con un Destino.\r\n\r\nEvangeline Fox se crio en la tienda de curiosidades de su amado padre, donde creció con leyendas sobre inmortales, como el trágico Príncipe de Corazones. Sabe que sus poderes son míticos, que vale la pena morir por su beso y que los tratos con el rara vez terminan bien. Pero cuando Evangeline se entera de que el amor de su vida está a punto de casarse con otra, se desespera lo suficiente como para ofrecerle al Príncipe de Corazones lo que quiera a cambio de su ayuda para detener la boda. El príncipe solo pide tres besos. Pero despues del primer beso prometido de Evangeline, se entera de que el Príncipe de Corazones quiere mucho más de ella de lo que ha prometido. Y tiene planes para Evangeline que terminarán en la mayor felicidad para siempre, o en la tragedia más exquisita.\r\n\r\n¿Hasta dónde serías capaz de llegar con tal de tener un final feliz?', 416, 'Castellano', 'Puck', '9788417854447', '2022-03-08', 21, 14, 'Tapa blanda', 14),
(15, 'La Maldición del Amor Verdadero', 18.50, 'lamaldiciondelverdaderoamor', 4, 'Dos villanos, una chica y una batalla mortal para conseguir un final feliz.\r\n\r\n\r\nEvangeline Fox viajó al Glorioso Norte buscando su «felices para siempre» y parece que lo ha conseguido: está casada con un atractivo príncipe y vive en un castillo legendario. Pero no tiene ni idea del devastador precio que ha pagado por ese cuento de hadas. Desconoce lo que ha perdido y su marido va a asegurarse de que no lo descubra nunca. pero antes debe matar a Jacks, el Príncipe de Corazones.\r\n\r\n\r\nEn esta obra, la cautivadora y esperada conclusión de la trilogía Érase una vez un corazón roto, se derramará sangre, se robarán algunos corazones y el amor verdadero será puesto a prueba.\r\n\r\n\r\nQue gane el mejor villano', 384, 'Castellano', 'Puck', '9788419252494', '2024-02-06', 21, 14, 'Tapa blanda', 15),
(16, 'La Ladrona de Libros', 21.90, 'laladornadelibros', 4, 'Una novela preciosa, tremendamente humana y emocionante, que describe  las peripecias de una niña alemana de nueve años desde que es dada en  adopción por su madre hasta el final de la II Guerra Mundial.\r\n\r\nUNO DE LOS 30 MEJORES NOVELAS HISTÓRICAS DE TODOS LOS TIEMPOS SEGÚNELLE\r\n\r\nÉrase una vez un pueblo donde las noches eran largas y la muerte contaba  su propia historia. En el pueblo vivía una niña que quería leer, un  hombre que tocaba el acordeón y un joven judío que escribía bellos  cuentos para escapar del horror de la guerra. Al cabo de un tiempo, la  niña se convirtió en una ladrona que robaba libros y regalaba palabras.  Con estas palabras se escribió una historia hermosa y cruel que ahora ya es una novela inolvidable.\r\n\r\n', 544, 'Castellano', 'Lumen', '9788426416216', '2007-09-07', 24, 16, 'Tapa dura', 16),
(17, 'Tan Poca Vida', 24.90, 'tanpocavida', 4, 'Para descubrir...\r\n\r\nQué dicen y qué callan los hombres.\r\n\r\nDe dónde viene y dónde va la culpa.\r\n\r\nCuánto importa el sexo.\r\n\r\nA quién podemos llamar amigo.\r\n\r\n\r\nY finalmente...\r\n\r\nQué precio tiene la vida y cuándo deja de tener valor.\r\n\r\n\r\nPara descubrir eso y más, aquí está Tan poca vida, una historia que recorre más de tres décadas de amistad en la vida de cuatro hombres que crecen juntos en Manhattan. Cuatro hombres que tienen que sobrevivir al fracaso y al éxito y que, a lo largo de los años, aprenden a sobreponerse a las crisis económicas, sociales y emocionales. Cuatro hombres que comparten una idea muy peculiar de la intimidad, una manera de estar juntos hecha de pocas palabras y muchos gestos. Cuatro hombres cuya relación la autora utiliza para realizar una minuciosa indagación de los límites de la naturaleza humana.', 1008, 'Castellano', 'Lumen', '9788426403278', '2016-09-15', 23, 15, 'Tapa blanda', 17),
(18, 'Hábitos Atómicos', 19.90, 'habitosatomicos', 4, 'A menudo pensamos que para cambiar de vida tenemos que pensar en hacer cambios grandes. Nada más lejos de la realidad. Según el reconocido experto en hábitos James Clear, el cambio real proviene del resultado de cientos de pequeñas decisiones: hacer dos flexiones al día, levantarse cinco minutos antes o hacer una corta llamada telefónica.\r\n\r\n\r\nClear llama a estas decisiones “hábitos atómicos”: tan pequeños como una partícula, pero tan poderosos como un tsunami. En este libro innovador nos revela exactamente cómo esos cambios minúsculos pueden crecer hasta llegar a cambiar nuestra carrera profesional, nuestras relaciones y todos los aspectos de nuestra vida.\r\n\r\n', 336, 'Castellano', 'Diana Editorial', '9788418118036', '2020-09-08', 23, 15, 'Tapa blanda', 18),
(19, 'Casa de LLama y Sombra', 21.95, 'ciudadmedialuna3', 0, 'Un mundo en la oscuridad.\r\n\r\n \r\nUna chispa ardiente.\r\n\r\n \r\nUn fulgor de las estrellas.\r\n\r\n \r\nBryce Quinlan nunca esperó ver otro mundo diferente a Midgard, pero, ahora que lo ha hecho, lo único que quiere es regresar a su hogar. Todo lo que ama está en Midgard: su familia, sus amigos, su pareja. Atrapada en un mundo extraño, necesitará hacer acopio de todo su ingenio para poder volver a casa... y no será una tarea fácil, porque no tiene ni idea de en quien puede confiar.\r\n\r\n \r\nHunt Athalar se ha visto envuelto en bastantes líos a lo largo de su vida, pero este podría ser el más complicado. Despues de conseguir todo lo que siempre quiso, ahora está de nuevo encerrado en los calabozos de los Asteri, sin conocer el paradero de Bryce. Está desesperado por ayudarla, pero mientras no pueda escapar del yugo de los Asteri, tiene las manos atadas. Literalmente.', 856, 'Castellano', 'Alfaguara', '9788419507570', '2024-02-22', 22, 15, 'Tapa blanda', 19),
(20, 'Casa de Tierra y Sangre', 21.95, 'ciudadmedialuna1', 4, 'Unidos por la sangre.\r\n\r\nTentados por el deseo.\r\n\r\nLiberados por el destino.\r\n\r\nBryce Quinlan tenía la vida perfecta, trabajando cada día y saliendo  cada noche, hasta que un demonio asesinó a sus amigos y la dejó vacía,  herida y sola. Cuando el acusado está entre rejas, pero los crímenes continúan, Bryce hará lo que sea para vengar sus muertes.\r\n\r\nHunt Athalar es un ángel caído, esclavo de los arcángeles a los que una  vez intentó destronar. Sus brutales habilidades sirven ahora para un  solo propósito: acabar con los enemigos de su dueño. Pero entonces Bryce  le ofrece un trato irresistible: si la ayuda a encontrar al demonio asesino, su libertad estará al alcance de su mano.\r\n\r\nMientras Bryce y Hunt investigan en las entrañas de Ciudad Medialuna,  descubren dos cosas: un poder oscuro que amenaza todo lo que desean proteger y una atracción feroz que podría liberarlos a ambos.', 800, 'Castellano', 'Alfaguara', '9788420452883', '2020-09-17', 22, 15, 'Tapa blanda', 20),
(21, 'Casa de Cielo y Aliento', 21.95, 'ciudadmedialuna2', 4, 'Unidos por la sangre.\r\n\r\n \r\nTentados por el deseo.\r\n\r\n \r\nLiberados por el destino.\r\n\r\n \r\nBryce Quinlan y Hunt Athalar han salvado Ciudad Medialuna,  por fin ha  llegado el momento de bajar la guardia y tratar de volver a la  normalidad. Para ello, han acordado tomárselo con calma y no empezar su  relación hasta el Solsticio de Invierno, si es que antes no incendian la ciudad con su deseo.\r\n\r\n \r\nPero todavía no están fuera de peligro. Cuando Bryce, Hunt y sus amigos  se ven involucrados en un movimiento rebelde del que no quieren formar  parte, se dan cuenta de que tienen que tomar una decisión: callar  mientras otros sufren o luchar por un mundo mejor.Y la verdad es que callar nunca se les ha dado bien.', 832, 'Castellano', 'Alfaguara', '9788420459257', '2022-03-03', 22, 15, 'Tapa blanda', 21),
(22, 'La Biblioteca de la Medianoche', 22.50, 'labibliotecadelamedianoche', 4, 'Nora Seed aparece, sin saber cómo, en la Biblioteca de la Medianoche, donde se le ofrece una nueva oportunidad para hacer las cosas bien. Hasta ese momento, su vida ha estado marcada por la infelicidad y el arrepentimiento.\r\n\r\nNora siente que ha defraudado a todos, y también a ella misma. Pero esto está a punto de cambiar.\r\n\r\nLos libros de la Biblioteca de la Medianoche permitirán a Nora vivir como si hubiera hecho las cosas de otra manera. Con la ayuda de una vieja amiga, tendrá la opción de esquivar todo aquello que se arrepiente de haber hecho (o no haber hecho), en pos de la vida perfecta. Pero las cosas no siempre serán como imaginó que serían, y pronto sus decisiones enfrentarán a la Biblioteca y a ella misma en un peligro extremo. Nora deberá responder una última pregunta antes de que el tiempo se agote: ¿cuál es la mejor manera de vivir?', 336, 'Castellano', 'Alianza Editorial', '9788413621654', '2021-02-18', 24, 17, 'Tapa blanda', 22),
(23, 'El Fabricante de Lágrimas', 19.90, 'elfabricantedelagrimas', 4, 'En el orfanato en el que Nica creció, siempre se han contado historias y  leyendas a la luz de la vela. La más famosa de todas es la del  fabricante de lágrimas, un misterioso artesano culpable de haber forjado  todos los miedos y las angustias que habitan en los corazones del ser  humano. Para Nica ya es hora de dejar atrás los cuentos de la infancia y  vivir lo que para ella es un sueño hecho realidad: ser adoptada. Pero no  cumplirá su sueño sola ya que la familia adoptiva acogerá tambien a  Rigel, un niño de rostro angelical pero que oculta algo oscuro en su  ser. Aunque ambos compartan un pasado en común, la convivencia entre  ellos parece imposible. Sobre todo, cuando la leyenda vuelve a aparecer  en sus vidas y el fabricante de lágrimas se convierte en algo muy real.', 640, 'Castellano', 'Montera', '9788419241511', '2023-01-26', 22, 14, 'Tapa blanda', 23),
(24, 'Magnolia Parks', 19.95, 'magnoliaparks', 3, 'Ella es una preciosa, rica, egoísta y un poco caprichosa socialité londinense.\r\n\r\n\r\nÉl es el chico malo más fotografiado de Inglaterra, y su rompecorazones particular.\r\n\r\n\r\nTodo el mundo sabe que Magnolia Parks y BJ Ballentine están hechos el uno para el otro.\r\n\r\n\r\nPero el destino no parece estar de su parte. Por mucho que Magnolia intente poner distancia saliendo con otra gente y BJ se acueste con otras chicas para vengarse, siempre acaban volviendo a los brazos del otro.\r\n\r\n\r\nEntre las cicatrices de un viejo amor y los secretos que por ellas asoman, Magnolia y BJ se verán obligados a encararse para responder a la pregunta que llevan toda la vida evitando:\r\n\r\n\r\n¿Cuántos amores tienes realmente en una vida?', 464, 'Castellano', 'Molino', '9788427240599', '2024-01-18', 22, 15, 'Tapa blanda', 24),
(25, 'Todos los Lugares que Mantuvimos en Secreto', 18.00, 'todosloslugaresquemantuvimosensecreto', 2, 'Maeve no sabe mucho sobre sí misma. Solo que no deja de pensar en si su madre cumplió todos sus sueños antes de morir, que la relación con su novio va cada vez peor y que está cansada de que todos sus días sean iguales.  Cuando, por un impulso, acaba comprando un billete solo de ida a la otra parte del mundo para volver al pueblo en el que vivió cuando era niña, lo que menos esperaba era reencontrarse allí con el que fue su mejor amigo de la infancia.  Connor siempre supo que tarde o temprano Maeve regresaría. Lo que nunca pensó es que fuera a ser así.  Tan caótica. Tan perdida. Como si aún estuviera por definir.  Si el miedo de ambos es desperdiciar sus vidas sin haber hecho nada que merezca la pena, ¿qué mejor que escribir una lista con todo lo que quieren hacer antes de morir y cumplirla juntos?', 680, 'Castellano', 'Editorial Planeta', '2910026421889', '2024-01-31', 23, 15, 'Tapa blanda', 25),
(26, 'Hija de la Tierra', 18.95, 'hijadelatierra', 5, 'Ziara vive en la Casa Verde y es una de las Novias del Nuevo Mundo, la esperanza de los últimos hombres.\r\n\r\n \r\nAún no ha sucedido, pero un día soñará con el hombre destinado a ella y cruzará los muros de su hogar para adentrarse en terreno desconocido:\r\n\r\n \r\nEn ese mundo del que la han protegido y que tanto ansía conocer.\r\n\r\n \r\nUn encuentro inesperado en el Bosque Sagrado, una unión entre dos personas que se ven obligadas a compartir camino y un secreto revelado harán que la vida de Ziara cambie para siempre.\r\n\r\n¿Estás preparado para adentrarte en el reino de Cathalian?', 432, 'Castellano', 'Alfaguara', '9788419507402', '2023-11-09', 21, 15, 'Tapa blanda', 26),
(27, 'Holly', 23.90, 'holly', 4, 'Cuando Penny Dahl contacta con Finders Keepers para que la ayuden a encontrar a su hija, algo en la voz desesperada de la mujer hace que Holly Gibney se vea obligada a aceptar el trabajo.\r\n\r\n \r\nA poca distancia del lugar en el que Bonnie Dahl desapareció, viven los profesores Rodney y Emily Harris. Son la quintaesencia de la respetabilidad burguesa: un matrimonio octogenario y dedicado de academicos semiretirados. Nadie diría que, en el sótano de su impecable casa forrada de libros, esconden un secreto directamente relacionado con la desaparición de Bonnie.\r\n\r\n \r\nSon astutos, pacientes y despiadados, y obligarán a Holly a emplear sus habilidades al máximo y a arriesgarlo todo si quiere cerrar el caso más oscuro al que se ha enfrentado jamás.', 624, 'Castellano', 'Plaza&Janes', '9788401031113', '2023-09-21', 23, 16, 'Tapa dura', 27),
(28, 'El Visitante', 23.90, 'elvisitante', 4, 'Un niño de once años ha sido brutalmente asesinado. Todas las pruebas  apuntan a uno de los ciudadanos más queridos de Flint City: Terry  Maitland, entrenador en la liga infantil, profesor de literatura, marido  ejemplar y padre de dos niñas. El detective Ralph Anderson ordena su  detención. Maitland tiene una coartada firme que demuestra que estuvo en  otra ciudad cuando se cometió el crimen, pero las pruebas de ADN encontradas en el lugar de los hechos confirman que es culpable. Ante la justicia y la opinión pública Terry Maitland es un asesino  y el caso está resuelto.\r\n\r\nPero el detective Anderson no está satisfecho. Maitland parece un buen  tipo, un ciudadano ejemplar, ¿acaso tiene dos caras? Y ¿cómo es posible que estuviera en dos sitios a la vez?\r\n\r\nLa respuesta, como no podría ser de otra forma saliendo de la pluma de  Stephen King, te hará desear no haber preguntado.', 592, 'Castellano', 'Plaza&Janes', '9788401021190', '2018-10-04', 24, 16, 'Tapa dura', 28),
(29, 'La Historia de Lisey', 21.50, 'lahistoriadelisey', 3, 'Hacía casi dos años que Lisey Debusher Landon había perdido a su marido Scott, después de veinticinco años de matrimonio y de una intimidad tan profunda que a veces les daba miedo. Scott había sido un escritor muy premiado y de gran éxito y también un hombre complicado. Al principio de su relación, Lisey tuvo que aprender mucho de él sobre libros, sobre sangre y sobre dálivas. Más adelante supo que había un lugar donde Scott se refugiaba, un lugar que cerraba sus heridas y le aterrorizaba a la vez, que le inspiraba todas las ideas que necesitaba para vivir pero que también podría devorarle. Ahora le toca a Lisey enfrentarse con los demonios de Scott. Le toca a Lisey viajar a Boo\'ya Moon. Lo que había empezado con la decisión de la viuda de ordenar los papeles de su marido famoso se convierte en un viaje casi mortal hacia la oscuridad que él habitó...', 600, 'Castellano', 'Plaza&Janes', '9788401336218', '2007-04-10', 23, 15, 'Tapa dura', 29),
(30, 'Todos los Hombres del Rey', 16.95, 'todosloshombresdelrey', 0, 'Cuando la vida deja de parecer un cuento de hadas, la magia más poderosa surge donde menos te lo esperas...\r\n\r\n \r\nFelicia ha alcanzado su final feliz y ha vuelto a casa de la mano de su príncipe desencantado. Ha pagado por ello un alto precio: renunciara la protección de su hada madrina. Sin embargo, cuando descubre que sus padres, los reyes de Vestur, la han mandado ejecutar a sus espaldas, deberá plantearse si su vida es realmente el cuento de hadas que parece.\r\n\r\n \r\nAsí, cuando la reina Crisantemo declara la guerra a Vestur en represalia por el crimen, Felicia decide emprender la búsqueda de la única persona que puede evitar el desastre. En su camino estará acompañada por un grupo de personajes de distintos orígenes que, por unas razones o por otras, tambien tienen cuentas pendientes con las hadas madrinas. Y contará con la ayuda de un antiguo cofre de madera que contiene un secreto extraordinario. ¿Será suficiente para salvar su reino de la cólera de las hadas?', 544, 'Castellano', 'Montena', '9788419975157', '2024-03-14', 21, 14, 'Tapa blanda', 30),
(31, 'Todas las Hadas del Reino', 10.95, 'todaslashadasdelreino', 5, 'Camelia es un hada madrina que lleva trescientos años ayudando con gran eficacia a jóvenes doncellas y a aspirantes a heroe para que alcancen sus propios finales felices. Su magia y su ingenio nunca le han fallado, pero todo empieza a complicarse cuando le encomiendan a Simón, un mozo de cuadra que necesita su ayuda desesperadamente. Camelia ha solucionado casos más difíciles; pero, por algún motivo, con Simón las cosas comienzan a torcerse de forma inexplicable...', 480, 'Castellano', 'B de Bolsillo', '9788413144603', '2024-02-15', 19, 12, 'Tapa blanda', 31),
(32, 'La Guerra de las Dos Reinas', 21.50, 'laguerradelasdosreinas', 4, 'Desde la desesperación de coronas doradas... \r\n\r\nCasteel Da\'Neer sabe demasiado bien que pocos son tan astutos o despiadados como la Reina de Sangre, pero nadie, ni siquiera él, pudo haberse preparado para esas sobrecogedoras revelaciones. La magnitud de que lo que la Reina de Sangre ha hecho es casi impensable.  \r\n\r\nY nacido de carne mortal...  \r\n\r\nNada podrá evitar que Poppy libere a su Rey y destruya todo lo que la Corona de Sangre representa. Con la fuerza de los guardias y el apoyo de loswolven, Poppy debe convencer a los generales de Atlantia de luchar a su manera, porque esta vez no puede haber retirada. No si ella mantiene la esperanza de construir un futuro en el que los dos reinos puedan convivir en paz.  \r\n\r\nUn gran poder primitivo se alza...  \r\n\r\nJuntos, Poppy y Casteel deben aceptar antiguas y nuevas tradiciones para salvaguardar a quienes aman y para proteger a los que no pueden defenderse. Pero la guerra es solo el principio. Poderes ancestrales y primitivos ya se han avivado, revelando el horror de lo que comenzó hace eones. Para terminar lo que la Reina de Sangre ha empezado, quizá Poppy tenga que convertirse en lo que habían profetizado que sería, en lo que más teme.\r\n\r\nComo la portadora de Muerte y Destrucción.', 800, 'Castellano', 'Puck', '9788417854836', '2022-11-22', 21, 13, 'Tapa blanda', 32),
(33, 'Una Sombra en las Brasas', 21.50, 'unasombraenlasbrasas', 5, 'Nacida envuelta en el velo de los Primigenios, una Doncella como prometieron los Hados, el futuro de Seraphena Mierel nunca ha sido suyo. Elegida antes de nacer para cumplir el trato desesperado que aceptó su antepasado para salvar a su gente, Sera debe dejar atrás su vida y ofrecerse al Primigenio de la Muerte como su consorte.\r\n\r\nSin embargo, el verdadero destino de Sera es el secreto mejor guardado de todo Lasania. No es la Doncella bien protegida que todos creen, sino una asesina con una misión, un objetivo: hacer que el Primigenio de la Muerte se enamore, convertirse en su debilidad, y despues.terminar con el. Si fracasa, condena a su reino a una muerte lenta a manos de la Podredumbre.\r\n\r\nSera siempre ha sabido lo que es. Elegida. Consorte. Asesina. Arma. Un espectro nunca del todo formado pero aun así empapado de sangre. Un monstruo. Hasta el. Hasta que las palabras y acciones inesperadas del Primigenio de la Muerte ahuyentan la oscuridad que se iba acumulando en su interior.', 800, 'Castellano', 'Puck', '9788417854515', '2022-06-07', 21, 13, 'Tapa blanda', 33),
(34, 'Una Luz en la Llama', 21.50, 'unaluzenlallama', 3, 'La verdad sobre el plan de Sera ha salido a la luz, y ha hecho pedazos la frágil confianza que se había forjado entre ella y Nyktos. Rodeada de personas que no confían en ella, solo le queda cumplir con su deber. Hará lo que sea necesario para acabar con Kolis, el falso Rey de Dioses, y su gobierno tiránico en el Iliseeum, y así detener la amenaza que supone para el mundo mortal.\r\n\r\n\r\nNo obstante, Nyktos tiene un plan, y mientras trabajan juntos lo último que necesitan es la innegable y abrasadora pasión que continúa ardiendo entre ellos. Sera no puede permitirse enamorarse del torturado Primigenio, especialmente ahora que la posibilidad de obtener una vida alejada de un destino que nunca quiso está más cerca que nunca.\r\n\r\n\r\nY cuando Sera comienza a darse cuenta de que quiere ser más que Consorte solo en el nombre, el peligro que los acecha se intensifica. Los ataques en las Tierras Umbrías se multiplican y cuando Kolis los convoca a la Corte, un nuevo riesgo se hace evidente. El poder Primigenio de la Vida crece en su interior y, sin el amor de Nyktos (una emoción que él es incapaz de sentir), no sobrevivirá. Eso si consigue alcanzar su Ascensión y Kolis no la atrapa primero.', 800, 'Castellano', 'Puck', '9788417854966', '2023-03-28', 21, 13, 'Tapa blanda', 34),
(35, 'Farsa de Amor a la Española', 19.95, 'farsadeamoralaespañola', 4, 'Cuatro semanas no son demasiado para encontrar a alguien dispuesto a acompañarte a la boda de tu hermana al otro lado del Atlántico, y menos aún si tiene que fingir que te ama. Suena ridículo, sí, pero lo es aún más que Aaron Blackford, el compañero de trabajo al que Catalina no soporta, se ofrezca a hacerlo.\r\n\r\nPero Lina está desesperada, y deberá sopesar qué es peor: aguantar a Aaron, con su aire petulante y sus ojos de hielo, o admitir a su familia que ha mentido y que es todo una farsa.\r\n\r\nComo diría su abuela: que Dios nos pille confesados.', 504, 'Castellano', 'VR Europa', '9788412477085', '2022-07-04', 23, 15, 'Tapa blanda', 35),
(36, 'La Bruja Blanca', 18.50, 'asesinodebrujas1', 4, 'Unidos como uno para amarse, para honrarse o para arder.\r\nDos años atrás, Louise le Blanc huyó de su aquelarre y se refugió en la ciudad de Cesarine, donde renunció a la magia para vivir de lo que pudiera robar. Allí, cazan a brujas como Lou. Les temen. Y las queman.\r\nComo cazador de la Iglesia, Reid Diggory ha vivido su vida bajo una regla: «No permitirás que ninguna bruja viva». Pero cuando Lou realiza una gran artimaña, tanto ella como Reid se ven obligados a aceptar una situación impensada: el matrimonio.\r\nLou, incapaz de ignorar sus sentimientos que son cada vez más fuertes, pero sin poder cambiar quién es, Lou debe elegir.\r\nAsesino de brujas: la bruja blanca se desarrolla en un mundo de mujeres empoderadas, magia oscura y donde los romances son fuera de serie. Cuando lo termines de leer, querrás más.', 480, 'Castellano', 'Puck', '9788417780708', '0000-00-00', 21, 13, 'Tapa blanda', 36),
(37, 'Los Hijos del Rey', 22.00, 'asesinodebrujas2', 4, 'La esperada secuela del exito de ventas deláNew York Times: Asesino de brujas. La bruja blanca.\r\n\r\nLou, Reid, Coco y Ansel huyen no solo del aquelarre, sino tambienádel reino y de la Iglesia. Son fugitivos y no tienen donde ocultarse.á\r\n\r\nPara sobrevivir, necesitan aliados. Y unos muy poderosos.áPero mientras Lou se preocupa cada vez más por salvar a sus seresáqueridos, se adentra en el lado oscuro de la magia. Y el precio a pagarápodría ser la persona a la que más teme perder: Reid.á\r\n\r\nEllos están unidos por un juramento y solo existe una cosa que puedeásepararlos: la muerte.', 512, 'Castellano', 'Puck', '9788417854126', '2021-01-12', 21, 13, 'Tapa blanda', 37),
(38, 'Dioses y Monstruos', 19.00, 'asesinodebrujas3', 3, 'Lou lleva toda su vida huyendo. Pero ahora, despues deáun golpe demoledor por parte de Morgane, ha llegado el momentoáde volver a casa. y reclamar lo que es suyo por derecho propio.\r\n\r\nPero esta ya no es la Lou que conocían sus amigos.á\r\n\r\nYa no es la Lou que le robó el corazón a un chasseur.\r\n\r\nUna especie de oscuridad se ha instalado en ella y, esta vez,áhará falta algo más que amor para espantarla.', 608, 'Castellano', 'Puck', '9788417854300', '2021-10-19', 21, 13, 'Tapa blanda', 38),
(39, 'Semihumana', 21.50, 'cazadoradehadas2', 3, 'odo lo que creía saber Ivy Morgan se ha venido abajo. Tras ser traicionada y estar a punto de morir a manos del Príncipe de los Faes, ha de guardar a toda costa un secreto perturbador. Porque, si la Orden lo descubre, la matará.\r\n\r\nY luego está Ren Owens, el miembro de la Élite de la Orden, tatuado e irresistible, que ha conquistado la cama y el corazón de Ivy. Entre ellos hay una química abrasadora, pero Ivy sabe que Ren valora por encima de todo su deber hacia la Orden. Jamás la tocaría si conociera la verdad. Tal vez incluso la mataría. Pero ¿puede Ivy seguir mintiendole?\r\n\r\nCuando el Príncipe de los Faes comienza a estrechar el cerco sobre ellos, decidido a abrir de manera permanente los portales hacia el Otro Mundo, Ivy se queda sin alternativas. ', 352, 'Castellano', 'Titania', '9788417421922', '2023-01-24', 22, 15, 'Tapa blanda', 39),
(40, 'Valiente', 21.50, 'cazadoradehadas3', 5, 'Hace tiempo que Ivy Morgan no es la misma de siempre. Y es comprensible. Que te secuestre el príncipe de los faes, un psicópata empeñado en abrir las puertas del Otro Mundo, es lógico que te deje algunas secuelas psicológicas. Pero no se trata solo de eso. Algo oscuro y dañino se está propagando por su interior, algo más poderoso de lo que la propia Ivy podría imaginar. y que se interpone entre ella y Ren Owens, el miembro de la Orden del que está locamente enamorada.\r\n\r\nRen haría cualquier cosa por mantener a Ivy a salvo. Lo que fuera. Sin embargo, cuando toma una decisión trascendental por ella, las consecuencias son de tal magnitud que amenazan con destrozar las vidas de ambos.', 352, 'Castellano', 'Titania', '9788417421939', '2023-01-24', 22, 15, 'Tapa blanda', 40),
(41, 'Marina', 17.90, 'marina', 3, 'Donde empieza la leyenda.\r\nEn la Barcelona de 1980 Óscar Drai sueña despierto, deslumbrado por los palacetes modernistas cercanos al internado en el que estudia. En una de sus escapadas conoce a Marina, una chica delicada de salud que comparte con Óscar la aventura de adentrarse en un enigma doloroso del pasado de la ciudad. Un misterioso personaje de la posguerra se propuso el mayor desafío imaginable, pero su ambición lo arrastró por sendas siniestras cuyas consecuencias debe pagar alguien todavía hoy.\r\n\r\n«Quince años más tarde, la memoria de aquel día ha vuelto a mí. He visto a aquel muchacho vagando entre las brumas de la estación de Francia y el nombre de Marina se ha encendido de nuevo como una herida fresca. Todos tenemos un secreto encerrado bajo llave en el ático del alma. Éste es el mío.»', 296, 'Castellano', 'Editorial Planeta', '9788408163572', '2016-10-25', 23, 15, 'Tapa dura', 41),
(42, 'El Príncipe de la Niebla', 17.00, 'elprincipedelaniebla', 5, 'El primer gran éxito de Carlos Ruiz Zafón.\r\nEl nuevo hogar de los Carver, que se han mudado a la costa huyendo de la ciudad y de la guerra, está rodeado de misterio.\r\nTodavía se respira el espíritu de Jacob, el hijo de los antiguos propietarios, que murió ahogado. Las extrañas circunstancias de esa muerte sólo se empiezan a aclarar con la aparición de un diabólico personaje: el Príncipe de la Niebla, capaz de conceder cualquier deseo a una persona; eso sí, a un alto precio.', 208, 'Castellano', 'Editorial Planeta', '9788408163541', '2016-10-25', 23, 15, 'Tapa dura', 42),
(43, 'La Sombra del Viento', 13.95, 'lasombradelviento', 3, 'Un amanecer de 1945, un muchacho es conducido por su padre a un misterioso lugar oculto en el corazón de la ciudad vieja: El Cementerio de los Libros Olvidados. Allí, Daniel Sempere encuentra un libro maldito que cambia el rumbo de su vida y le arrastra a un laberinto de intrigas y secretos enterrados en el alma oscura de la ciudad. La Sombra del Viento es un misterio literario ambientado en la Barcelona de la primera mitad del siglo XX, desde los últimos esplendores del Modernismo hasta las tinieblas de la posguerra.\r\n\r\n \r\nAunando las técnicas del relato de intriga y suspense, la novela histórica y la comedia de costumbres, La Sombra del Viento es sobre todo una trágica historia de amor cuyo eco se proyecta a través del tiempo. Con gran fuerza narrativa, el autor entrelaza tramas y enigmas a modo de muñecas rusas en un inolvidable relato sobre los secretos del corazón y el embrujo de los libros cuya intriga se mantiene hasta la última página.', 592, 'Castellano', 'Booket', '9788408278573', '2023-10-04', 20, 13, 'Tapa dura', 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_populares`
--

CREATE TABLE `libros_populares` (
  `id_libro` int(11) NOT NULL,
  `popularidad` int(11) NOT NULL DEFAULT 0,
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros_populares`
--

INSERT INTO `libros_populares` (`id_libro`, `popularidad`, `fecha_modificacion`) VALUES
(1, 0, '2024-02-17 15:23:06'),
(2, 0, '2024-02-17 14:59:48'),
(3, 0, '2024-02-17 14:59:48'),
(4, 0, '2024-02-17 14:59:48'),
(5, 0, '2024-02-17 14:59:48'),
(6, 0, '2024-02-17 14:59:48'),
(7, 0, '2024-02-17 14:59:48'),
(8, 0, '2024-02-17 14:59:48'),
(9, 0, '2024-02-17 14:59:48'),
(10, 0, '2024-02-17 14:59:48'),
(11, 0, '2024-02-17 14:59:48'),
(12, 0, '2024-02-17 14:59:48'),
(13, 0, '2024-02-17 14:59:48'),
(14, 0, '2024-02-17 14:59:48'),
(15, 0, '2024-02-17 15:13:47'),
(16, 0, '2024-02-17 14:59:48'),
(17, 0, '2024-02-17 15:13:45'),
(18, 0, '2024-02-17 14:59:48'),
(19, 0, '2024-02-17 14:59:48'),
(20, 0, '2024-02-17 14:59:48'),
(21, 0, '2024-02-17 14:59:48'),
(22, 0, '2024-02-17 14:59:48'),
(23, 0, '2024-02-17 14:59:48'),
(24, 0, '2024-02-17 14:59:48'),
(25, 0, '2024-02-17 14:59:48'),
(26, 0, '2024-02-17 14:59:48'),
(27, 0, '2024-02-17 14:59:48'),
(28, 0, '2024-02-17 14:59:48'),
(29, 0, '2024-02-17 14:59:48'),
(30, 0, '2024-02-17 14:59:48'),
(31, 0, '2024-02-17 14:59:48'),
(32, 0, '2024-02-17 14:59:48'),
(33, 0, '2024-02-17 14:59:48'),
(34, 0, '2024-02-17 14:59:48'),
(35, 0, '2024-02-17 14:59:48'),
(36, 0, '2024-02-17 14:59:48'),
(37, 0, '2024-02-17 14:59:48'),
(38, 0, '2024-02-17 14:59:48'),
(39, 0, '2024-02-17 14:59:48'),
(40, 0, '2024-02-17 14:59:48'),
(41, 0, '2024-02-17 14:59:48'),
(42, 0, '2024-02-17 14:59:48'),
(43, 0, '2024-02-17 14:59:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_autor`
--

CREATE TABLE `libro_autor` (
  `id_libro_autor` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libro_autor`
--

INSERT INTO `libro_autor` (`id_libro_autor`, `id_autor`, `id_libro`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 10, 21),
(4, 10, 19),
(5, 10, 20),
(6, 4, 9),
(7, 4, 4),
(8, 19, 38),
(9, 12, 23),
(10, 1, 42),
(11, 16, 28),
(12, 18, 35),
(13, 15, 26),
(14, 16, 27),
(15, 9, 18),
(16, 6, 13),
(17, 11, 22),
(18, 19, 36),
(19, 4, 32),
(20, 16, 29),
(21, 7, 16),
(22, 6, 15),
(23, 1, 43),
(24, 19, 37),
(25, 13, 24),
(26, 1, 41),
(27, 5, 12),
(28, 3, 3),
(29, 5, 11),
(30, 4, 39),
(31, 8, 17),
(32, 17, 31),
(33, 17, 30),
(34, 14, 25),
(35, 4, 6),
(36, 4, 8),
(37, 4, 34),
(38, 4, 33),
(39, 4, 7),
(40, 4, 5),
(41, 4, 40),
(42, 5, 10),
(43, 6, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_categoria`
--

CREATE TABLE `libro_categoria` (
  `id_libro_categoria` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libro_categoria`
--

INSERT INTO `libro_categoria` (`id_libro_categoria`, `id_categoria`, `id_libro`) VALUES
(1, 1, 1),
(2, 3, 1),
(3, 2, 1),
(4, 1, 2),
(5, 3, 2),
(6, 2, 2),
(7, 1, 3),
(8, 3, 3),
(9, 2, 3),
(10, 1, 4),
(11, 3, 4),
(12, 2, 4),
(13, 1, 5),
(14, 3, 5),
(15, 2, 5),
(16, 1, 6),
(17, 3, 6),
(18, 2, 6),
(19, 1, 7),
(20, 3, 7),
(21, 2, 7),
(22, 1, 8),
(23, 3, 8),
(24, 2, 8),
(25, 1, 9),
(26, 3, 9),
(27, 2, 9),
(28, 5, 10),
(29, 6, 10),
(30, 7, 10),
(31, 5, 11),
(32, 6, 11),
(33, 8, 11),
(34, 5, 12),
(35, 9, 12),
(36, 10, 12),
(37, 1, 13),
(38, 2, 13),
(39, 3, 13),
(40, 1, 14),
(41, 2, 14),
(42, 3, 14),
(43, 1, 15),
(44, 2, 15),
(45, 3, 15),
(46, 5, 16),
(47, 11, 16),
(48, 12, 16),
(49, 5, 17),
(50, 6, 17),
(51, 8, 17),
(52, 13, 18),
(53, 14, 18),
(54, 1, 19),
(55, 2, 19),
(56, 3, 19),
(57, 1, 20),
(58, 2, 20),
(59, 3, 20),
(61, 1, 21),
(62, 2, 21),
(63, 3, 21),
(64, 5, 22),
(65, 6, 22),
(66, 8, 22),
(67, 1, 23),
(68, 2, 23),
(69, 4, 23),
(70, 1, 24),
(71, 2, 24),
(72, 4, 24),
(73, 1, 25),
(74, 2, 25),
(75, 4, 25),
(76, 1, 26),
(77, 16, 26),
(78, 3, 26),
(79, 5, 27),
(80, 17, 27),
(81, 5, 28),
(82, 17, 28),
(83, 5, 29),
(84, 11, 29),
(85, 18, 29),
(86, 1, 30),
(87, 16, 30),
(88, 3, 30),
(89, 1, 31),
(90, 16, 31),
(91, 3, 31),
(92, 1, 32),
(93, 2, 32),
(94, 3, 32),
(95, 1, 33),
(96, 2, 33),
(97, 3, 33),
(98, 1, 34),
(99, 2, 34),
(100, 3, 34),
(101, 5, 35),
(102, 9, 35),
(103, 10, 35),
(104, 1, 36),
(105, 2, 36),
(106, 3, 36),
(107, 1, 37),
(108, 2, 37),
(109, 3, 37),
(110, 1, 38),
(111, 2, 38),
(112, 3, 38),
(113, 1, 39),
(114, 2, 39),
(115, 3, 39),
(116, 1, 40),
(117, 2, 40),
(118, 3, 40),
(119, 5, 41),
(120, 6, 41),
(121, 7, 41),
(122, 1, 42),
(123, 16, 42),
(124, 19, 42),
(125, 5, 43),
(126, 6, 43),
(127, 7, 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_pedido` enum('Recogida','Envio') NOT NULL,
  `total_pedido` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `fecha_pedido`, `tipo_pedido`, `total_pedido`) VALUES
(1, 7, '2024-02-18 10:57:33', 'Envio', 46.80),
(2, 7, '2024-02-18 10:59:02', 'Envio', 0.00),
(3, 7, '2024-02-18 10:59:52', 'Envio', 0.00),
(4, 7, '2024-02-18 11:00:30', 'Envio', 0.00),
(5, 7, '2024-02-18 11:00:34', 'Envio', 0.00),
(6, 7, '2024-02-18 11:00:56', 'Envio', 0.00),
(7, 7, '2024-02-18 11:01:19', 'Envio', 0.00),
(8, 8, '2024-02-18 20:10:01', 'Envio', 284.85),
(9, 7, '2024-02-22 09:21:07', 'Envio', 23.90);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_cesta`
--

CREATE TABLE `productos_cesta` (
  `id_producto_cesta` int(11) NOT NULL,
  `id_cesta` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id_stock`, `id_libro`, `cantidad`) VALUES
(1, 1, 8),
(2, 2, 5),
(3, 3, 10),
(4, 4, 9),
(5, 5, 10),
(6, 6, 10),
(7, 7, 5),
(8, 8, 10),
(9, 9, 10),
(10, 10, 10),
(11, 11, 10),
(12, 12, 10),
(13, 13, 10),
(14, 14, 10),
(15, 15, 10),
(16, 16, 8),
(17, 17, 9),
(18, 18, 10),
(19, 19, 6),
(20, 20, 10),
(21, 21, 10),
(22, 22, 10),
(23, 23, 10),
(24, 24, 10),
(25, 25, 10),
(26, 26, 10),
(27, 27, 9),
(28, 28, 9),
(29, 29, 10),
(30, 30, 8),
(31, 31, 10),
(32, 32, 10),
(33, 33, 10),
(34, 34, 10),
(35, 35, 10),
(36, 36, 10),
(37, 37, 10),
(38, 38, 10),
(39, 39, 10),
(40, 40, 10),
(41, 41, 10),
(42, 42, 10),
(43, 43, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(60) NOT NULL,
  `id_cesta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellidos`, `email`, `usuario`, `contraseña`, `id_cesta`) VALUES
(7, 'manuel', 'rodrigo', 'correo@correo.com', 'manuel', '$2y$10$lXSJTw5rh7nMkDSATAhJ/O4vFDVqfKdCssUwiL5EJQ87lJlJHT.zu', 7),
(8, 'alicia', 'velasco', 'aliciaveca12663@gmail.com', 'alicia12663', '$2y$10$f/sMRrmlaH9Sbvff7lob8.cm9lz754n94hMSeEDFB0ufMXR3HSSsy', 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id_autor`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cesta`
--
ALTER TABLE `cesta`
  ADD PRIMARY KEY (`id_cesta`),
  ADD KEY `fk_cesta_usuarios` (`id_usuario`) USING BTREE;

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detallePedido_pedido` (`id_pedido`),
  ADD KEY `fk_detallepedido_libros` (`id_libro`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id_favoritos`),
  ADD KEY `fk_favoritos_usuario` (`id_usuario`),
  ADD KEY `fk_favoritos_libros` (`id_libro`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `fk_libros_stock` (`id_stock`);

--
-- Indices de la tabla `libros_populares`
--
ALTER TABLE `libros_populares`
  ADD PRIMARY KEY (`id_libro`);

--
-- Indices de la tabla `libro_autor`
--
ALTER TABLE `libro_autor`
  ADD PRIMARY KEY (`id_libro_autor`),
  ADD KEY `fk_libroAutor_autores` (`id_autor`),
  ADD KEY `fk_libroAutor_libros` (`id_libro`);

--
-- Indices de la tabla `libro_categoria`
--
ALTER TABLE `libro_categoria`
  ADD PRIMARY KEY (`id_libro_categoria`),
  ADD KEY `fk_libroCategoria_libros` (`id_libro`),
  ADD KEY `fk_libroCategoria_categoria` (`id_categoria`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedidos_usuarios` (`id_usuario`);

--
-- Indices de la tabla `productos_cesta`
--
ALTER TABLE `productos_cesta`
  ADD PRIMARY KEY (`id_producto_cesta`),
  ADD KEY `fk_productosCesta_cesta` (`id_cesta`),
  ADD KEY `fk_productosCesta_libros` (`id_libro`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `fk_stock_libros` (`id_libro`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_usuarios_cesta` (`id_cesta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id_favoritos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `libro_autor`
--
ALTER TABLE `libro_autor`
  MODIFY `id_libro_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `productos_cesta`
--
ALTER TABLE `productos_cesta`
  MODIFY `id_producto_cesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cesta`
--
ALTER TABLE `cesta`
  ADD CONSTRAINT `fk_cesta_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_detallePedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallepedido_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `fk_favoritos_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_favoritos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `fk_libros_stock` FOREIGN KEY (`id_stock`) REFERENCES `stock` (`id_stock`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `libros_populares`
--
ALTER TABLE `libros_populares`
  ADD CONSTRAINT `fk_librosPopulares_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `libro_autor`
--
ALTER TABLE `libro_autor`
  ADD CONSTRAINT `fk_libroAutor_autores` FOREIGN KEY (`id_autor`) REFERENCES `autores` (`id_autor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_libroAutor_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `libro_categoria`
--
ALTER TABLE `libro_categoria`
  ADD CONSTRAINT `fk_libroCategoria_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_libroCategoria_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos_cesta`
--
ALTER TABLE `productos_cesta`
  ADD CONSTRAINT `fk_productosCesta_cesta` FOREIGN KEY (`id_cesta`) REFERENCES `cesta` (`id_cesta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productosCesta_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_stock_libros` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_cesta` FOREIGN KEY (`id_cesta`) REFERENCES `cesta` (`id_cesta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
