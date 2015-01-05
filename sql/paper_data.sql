INSERT IGNORE into `Printers` (`PrinterId`, `PrinterName`) VALUES
    (1, 'Finao Standard'),
    (2,	'The Edge'),
    (3,	'WHCC'),
    (4,	'Finao Metallic'),
    (5,	'Bind Only'),
    (6,	'ProDPI (Ship Prints)'),
    (7,	'ProDPI Standard'),
    (8,	'ProDPI Pearl'),
    (9,	'Base Price');

INSERT IGNORE INTO `Types` (`TypeId`, `TypeName`, `EntityName`) VALUES
    (2, `PrinterCollection`, `Printers`);

INSERT IGNORE INTO `Lists` (`ListId`, `TypeId`, `ListName`) VALUES
    (54, 2, 'One Product Printers'),

INSERT IGNORE INTO `ListXref` (`MemberId`, `ListId`) VALUES
    (1, 54),
    (2, 54),
    (3, 54),
    (4, 54),
    (5, 54),
    (6, 54),
    (7, 54),
    (8, 54),
    (9, 54);