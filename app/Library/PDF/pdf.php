<?php
namespace App\Library\PDF;

class PDF {
    //public static $mpdf;
    // public $quoteNumber;
    // public $sender;
    // public $recipient;
    // public $items = [];
    // public $item;
    // public $tax;
    // public $termsConditions = [];

    public static function create() {
        // Create an instance of the class
        $mpdf = new \Mpdf\Mpdf();

        // Variables below
        $quoteNumber = array_fill_keys(array('year', 'division', 'sales', 'month', 'number'), '');
        $sender = array_fill_keys(array('name', 'addr', 'phone', 'email'), '');
        $recipient = array_fill_keys(array('name', 'addr', 'phone', 'email'), '');
        $item = array_fill_keys(array('name', 'quantity', 'price'), '');
        $items = [];
        $tax = 11;
        $termsConditions = [];

        // ! ------------------------==================================
        // ! Test values
        // ! TODO: Delete this block of comment when finished
        $quoteNumber['year'] = '2021';
        $quoteNumber['division'] = 'DIV';
        $quoteNumber['sales'] = 'SAL';
        $quoteNumber['month'] = 'IX';
        $quoteNumber['number'] = '014';

        $sender['name'] = 'Sender Name';
        $sender['addr'] = 'KETAPANG BUSINESS CENTER BLOK D2-D3 NO. 20, Jl. Kyai Haji Zainul Arifin';
        $sender['phone'] = '+62 21 6348020';
        $sender['email'] = 'email@email.com';

        $recipient['name'] = 'Recipient Name';
        $recipient['addr'] = 'KETAPANG BUSINESS CENTER BLOK D2-D3 NO. 20, Jl. Kyai Haji Zainul Arifin';
        $recipient['phone'] = '+62 dfsfaf324432';
        $recipient['email'] = 'emailrecipient@email.com';

        // ITEM 1
        $item['name'] = 'MSI GL65-9SC-028ID (Ci7-9750H/512GB/8GB/GTX1650/4GfdsafasdfdsafsdfsadfdsafasdfdsafdsafdsdB/W10H/2YR)';
        $item['quantity'] = 2;
        $item['price'] = 14499000;
        $items[] = $item;

        // ITEM 2
        $item['name'] = 'MSI GL65-9SC-028ID (Ci7-9750H/512GB/8GB/GTX1650/4GBdfasfdsafasdfsdafdsafsfsd/W10H/2YR)';
        $item['quantity'] = 3;
        $item['price'] = 14499000;
        $items[] = $item;

        $termsConditions[] = 'This is TnC number 1';
        $termsConditions[] = 'This is TnC number 2';
        $termsConditions[] = 'This is TnC number 3';
        $termsConditions[] = 'This is TnC number 4';
        $termsConditions[] = 'This is TnC number 5';
        // ! ------------------------==================================

        // Template
        $template = $mpdf->setSourceFile(app_path('Library/PDF/template.pdf'));
        $fileId = $mpdf->importPage($template);
        $mpdf->useTemplate($fileId);

        // Show or hide cell borders. 1 for show, 0 for hide
        $border = 0;

        // Write title and PDS logo
        $mpdf->SetY(25);

        // Cell width and height
        $cellWidth = 0;
        $cellHeight = 14;

        // Font size
        $fontSize = 24;

        // Write title
        $title = 'Quotation';
        $mpdf->SetFont('', 'B', $fontSize);
        $mpdf->WriteCell($cellWidth, $cellHeight, $title, $border, 0);
        $mpdf->SetFont('', '', 12); // Reset font settings

        // Display logo
        $mpdf->Image(app_path('Library/PDF/pdslogo.png'), 140, $mpdf->y, 55);

        $mpdf->SetY($mpdf->y);

        // Generate quote number
        $combinedString =
            $quoteNumber['year'] . '/' .
            $quoteNumber['division'] . '/' .
            $quoteNumber['sales'] . '/' .
            $quoteNumber['month'] . '/' .
            $quoteNumber['number'];

        // Quote number cell width and height
        $cellWidth = 0;
        $cellHeight = 7;

        // Write quote number
        $mpdf->WriteCell($cellWidth, $cellHeight, 'No       : ' . $combinedString, $border, 2);

        // Date cell width and height
        $cellWidth = 0;
        $cellHeight = 7;

        // Get current date with built-in PHP date() function
        date_default_timezone_set('Asia/Jakarta');  // Set timezone to Asia/Jakarta
        $date = date('l, d F Y');

        // Write date
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Date    : ' . $date, $border, 2);

        // *==============================
        // * Draw sender and recipient boxes
        // *==============================
        // Rectangle settings
        $rectWidth = 87;
        $rectHeight = 40;
        $roundedRadius = 2; // Rounded corners radius (in millimeter)
        $fillColor_R = 211;
        $fillColor_G = 211;
        $fillColor_B = 211;

        // Set fill color;
        $mpdf->SetFillColor($fillColor_R, $fillColor_G, $fillColor_B);

        // Draw rectangle for sender field
        $mpdf->RoundedRect($mpdf->x, $mpdf->y, $rectWidth, $rectHeight, 2, 'F');

        // Rectangle for recipient field
        $mpdf->RoundedRect($mpdf->x + 93, $mpdf->y, $rectWidth, $rectHeight, 2, 'F');

        // Y position after drawing the boxes
        $endBoxYPos = $mpdf->y + $rectHeight;

        // *==============================
        // * Sender and recipient texts
        // *==============================
        // Write Cell max width and height for sender
        $cellWidth = 80;
        $cellHeight = 4.5;

        // Store Y pos before writing everything
        $currentYPos = $mpdf->y;

        // Font family and size
        $fontFamily = 'Times';
        $fontSize = 9;

        // SENDER
        $mpdf->SetFont('Helvetica', 'BU', $fontSize + 3);

        $mpdf->WriteCell($cellWidth, $cellHeight + 3, 'QUOTATION FROM', 'B', 2);
        // Name, in bold
        $mpdf->SetFont($fontFamily, 'B', $fontSize);
        $mpdf->WriteCell($cellWidth, $cellHeight, $sender['name'], $border, 2);

        // Address
        $mpdf->SetFont($fontFamily, '', $fontSize - 1);
        $tmpX = $mpdf->x;
        $mpdf->MultiCell($cellWidth, $cellHeight, $sender['addr'], $border);
        $mpdf->SetX($tmpX);

        // Phone
        $mpdf->WriteCell($cellWidth, $cellHeight, $sender['phone'], $border, 2);

        // Email
        $mpdf->WriteCell($cellWidth, $cellHeight, $sender['email'], $border, 1);

        // Get back to the Y pos before writing everything
        $mpdf->SetY($currentYPos);

        // RECIPIENT
        // Write Cell max width and height for recipient
        $cellWidth = 80;
        $cellHeight = 4.5;

        // Store Y pos before writing everything
        $currentYPos = $mpdf->y;

        $mpdf->SetFont('Helvetica', 'BU', $fontSize + 3);
        $mpdf->SetX($mpdf->x + 95);
        $mpdf->WriteCell($cellWidth, $cellHeight + 3, 'QUOTATION TO', 'B', 2);

        // Name, in bold
        $mpdf->SetFont($fontFamily, 'B', $fontSize);
        $mpdf->WriteCell($cellWidth, $cellHeight, $recipient['name'], $border, 2);

        // Address
        $mpdf->SetFont($fontFamily, '', $fontSize - 1);
        $tmpX = $mpdf->x;
        $mpdf->MultiCell($cellWidth, $cellHeight, $recipient['addr'], $border);
        $mpdf->SetX($tmpX);

        // Phone
        $mpdf->WriteCell($cellWidth, $cellHeight, $recipient['phone'], $border, 2);

        // Email
        $mpdf->WriteCell($cellWidth, $cellHeight, $recipient['email'], $border, 1);

        // Get back to the Y pos before writing everything
        $mpdf->SetY($currentYPos);

        // *===========================
        // * Draw table for items
        // *===========================
        $mpdf->SetY($endBoxYPos + 5);

        $itemNumWidth = 10;
        $itemNameWidth = 100;
        $itemQuantityWidth = 10;
        $uPriceWidth = 30;
        $tPriceWidth = 30;

        $cellHeight = 5;

        $mpdf->SetFont('Arial', 'B', 9);
        $mpdf->WriteCell($itemNumWidth, $cellHeight, 'No.', 1, 0, 'C');
        $mpdf->WriteCell($itemNameWidth, $cellHeight, 'Item', 1, 0, 'C');
        $mpdf->WriteCell($itemQuantityWidth, $cellHeight, 'Qty', 1, 0, 'C');
        $uPriceXPos = $mpdf->x;
        $mpdf->WriteCell($uPriceWidth, $cellHeight, 'Item Price (IDR)', 1, 0, 'C');
        $mpdf->WriteCell($tPriceWidth, $cellHeight, 'Total Price (IDR)', 1, 1, 'C');

        // *===========================
        // * Fill table with items
        // *===========================
        // Item number cell max width and height
        $itemNumCellWidth = 10;
        $itemNumCellHeight = 5;

        // Item name cell max width and height
        $nameCellWidth = 100;
        $nameCellHeight = $itemNumCellHeight;

        // Item quantity cell max width and height
        $quantityCellWidth = 10;
        //$quantityCellHeight = $itemNumCellHeight;

        // Unit price cell max width and height
        $uPriceCellWidth = 30;
        //$uPriceCellHeight = $itemNumCellHeight;

        // Total price cell max width and height
        $tPriceCellWidth = 30;
        //$tPriceCellHeight = $itemNumCellHeight;

        // Font family and size
        $fontFamily = 'Helvetica';
        $fontSize = 8;

        // Add items to table in the template
        $mpdf->SetFont($fontFamily, '', $fontSize);
        for ($i = 0; $i < count($items); $i++) {
            $startY = $mpdf->y;

            // Item name
            $mpdf->SetX($mpdf->x + $itemNumCellWidth);
            // Get current position before calling MultiCell()
            $x = $mpdf->x;
            $y = $mpdf->y;
            $mpdf->MultiCell($nameCellWidth, $nameCellHeight, $items[$i]['name'], 'TLB');
            $nameActualCellHeight = $mpdf->y;   // Get current Y position after calling MultiCell()

            // Item quantity
            // Set current position to correct position before calling WriteCell()
            $mpdf->SetXY($x + $nameCellWidth, $y);
            $mpdf->WriteCell($quantityCellWidth, $nameActualCellHeight - $mpdf->y, strval($items[$i]['quantity']), 'TLB', 0, 'C');

            // Unit price
            $mpdf->WriteCell($uPriceCellWidth, $nameActualCellHeight - $mpdf->y, 'Rp. ' . number_format($items[$i]['price']), 'TLB', 0, 'R');

            // Total price
            $totalPrice = $items[$i]['price'] * $items[$i]['quantity'];   // Calculate the total price(unit price * quantity)
            $mpdf->WriteCell($tPriceCellWidth, $nameActualCellHeight - $mpdf->y, 'Rp. ' . number_format($totalPrice), 'TLRB', 1, 'R');

            // Item number
            $mpdf->SetY($startY);
            $mpdf->WriteCell($itemNumCellWidth, $nameActualCellHeight - $mpdf->y, strval($i + 1), 'TLB', 0, 'C');

            // Set the position for the next item to be written to the table in the template
            $mpdf->SetY($nameActualCellHeight);
        }


        // *===========================
        // * Output PDF
        // *===========================
        $mpdf->Output();
    }
}
