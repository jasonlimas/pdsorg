<?php
namespace App\Library\PDF;

class pdf {
    public static function create($logoPath, $quoteNumber, $date, $sender, $recipient, $items, $tax, $termsConditions, $banks, $attachmentPath) {
        // Create an instance of the class
        $mpdf = new \Mpdf\Mpdf();

        // *===================================== *
        // * PDF template. Located in the same directory as this file
        // *===================================== *
        $template = $mpdf->setSourceFile(app_path('Library/PDF/template.pdf'));
        $fileId = $mpdf->importPage($template);
        $mpdf->useTemplate($fileId);

        // *===================================== *
        // * Show border for all elements
        // * (for debugging purposes)
        // *===================================== *
        $border = 0;

        // *===================================== *
        // * Quote title
        // *===================================== *
        $mpdf->SetY(25);
        PDF::writeQuotationTitle($mpdf, $logoPath, $border);

        // *===================================== *
        // * Quote number and date
        // *===================================== *
        PDF::writeQuoteNumber($mpdf, $quoteNumber, $border);
        PDF::writeDate($mpdf, $date, $border);

        // *===================================== *
        // * Draw sender and receiver box
        // *===================================== *
        $mpdf->SetY($mpdf->y + 2);
        $endBoxYPos = PDF::drawSenderRecipientBoxes($mpdf);

        // *===================================== *
        // * Write sender and receiver details
        // *===================================== *
        $mpdf->SetXY($mpdf->x + 3, $mpdf->y + 1);
        $newYPos = PDF::writeSenderOrRecipient($mpdf, true, $sender, $border);
        $mpdf->SetY($newYPos);
        PDF::writeSenderOrRecipient($mpdf, false, $recipient, $border);

        // *===================================== *
        // * Draw table header and fill the table
        // *===================================== *
        $mpdf->SetY($endBoxYPos + 5);
        $newXPos = PDF::drawItemTable($mpdf);
        $newYPos = PDF::writeItems($mpdf, $items);

        // *===================================== *
        // * Write total price
        // *===================================== *
        $mpdf->SetXY($newXPos, $newYPos);
        $grandtotal = PDF::writeTotal($mpdf, $items, $tax);

        // *===================================== *
        // * Total in words
        // *===================================== *
        $mpdf->SetXY(15, $mpdf->y + 3);
        PDF::writeTotalInWords($mpdf, $grandtotal, $border);

        $mpdf->SetFont('', '');
        $mpdf->WriteCell(0, 13, 'Terima kasih atas kerja sama Anda, berharap untuk mendengar dari Anda segera.', $border, 2);

        // *===================================== *
        // * Terms and conditions field
        // *===================================== *
        $mpdf->SetY($mpdf->y + 3);
        PDF::writeTermsConditions($mpdf, $termsConditions, $border);

        // *===================================== *
        // * Transfer to bank details
        // *===================================== *
        $tempYPos = $mpdf->y;
        $mpdf->SetY($mpdf->y + 15);
        PDF::writeBankDetails($mpdf, $banks);

        // *===================================== *
        // * Best regards field
        // *===================================== *
        $mpdf->SetXY(135, $tempYPos + 15);
        PDF::writeBestRegards($mpdf, $sender, $border);

        // *===================================== *
        // * Attachment
        // *===================================== *
        PDF::addAttachment($mpdf, $attachmentPath);

        // *===================================== *
        // * Output PDF
        // *===================================== *
        $outputName = PDF::buildQuoteNumber($quoteNumber, '-');
        $mpdf->Output('Quotation ' . $outputName . '.pdf', 'I');

        return response()->streamDownload(
            fn() => 'export_protocol.pdf'
        );
    }

    /**
     * Write quotation text title and the logo specified in the parameter
     *
     * @param MPDF $mdpf: MPDF object
     * @param string $imgPath: Path to the logo image
     * @param int $border: Border value
     *
     * @return void
     */
    private static function writeQuotationTitle($mpdf, $imgPath, $border) {
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
        if ($imgPath) {
            $mpdf->Image($imgPath, 145, $mpdf->y);
        }

        $mpdf->SetY($mpdf->y);
    }

    /**
     * Function to write the quotation number to the PDF.
     *
     * @param MPDF $mpdf: MPDF object
     * @param array $number: Quote number data
     * @param int $border: Border value
     *
     * @return void
     */
    private static function writeQuoteNumber($mpdf, $number, $border) {
        // Quote number cell width and height
        $cellWidth = 0;
        $cellHeight = 7;

        // Build quote number
        $combinedString = PDF::buildQuoteNumber($number, '/');

        // Write quote number
        $mpdf->WriteCell($cellWidth, $cellHeight, 'No       : ' . $combinedString, $border, 2);
    }

    /**
     * Function to write the date to the PDF.
     *
     * This function will take the current date, then
     * write it in the PDF. Format is:
     *  day(word), dd month(word) yyyy
     *
     * @param MPDF $mpdf: MPDF object
     * @param int $border: Border value
     *
     * @return void
     */
    private static function writeDate($mpdf, $date, $border) {
        // Dater cell width and height
        $cellWidth = 0;
        $cellHeight = 7;

        // Get current date with built-in PHP date() function
        // date_default_timezone_set('Asia/Jakarta');  // Set timezone to Asia/Jakarta
        // $date = date('l, d F Y');
        $brokenDate = explode('-', $date);
        $formattedDate = date('l, d F Y', mktime(0, 0, 0, $brokenDate[1], $brokenDate[2], $brokenDate[0]));

        // Write date
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Date    : ' . $formattedDate, $border, 2);
    }

    /**
     * Function to draw the sender and receiver boxes.
     *
     * This function will draw the sender and receiver boxes
     * and return the Y position of the bottom of the box.
     *
     * @param MPDF $mpdf: MPDF object
     * @param bool $isSender: Default is true. True if sender box, false if receiver box
     * @param array $data: Sender or receiver data
     * @param int $border: Border value
     *
     * @return float $endBoxYPos: Y position before calling this function
     */
    private static function writeSenderOrRecipient($mpdf, $isSender = true, $data, $border) {
        // Write Cell max width and height
        $cellWidth = 80;
        $cellHeight = 4.5;

        // Font family and size
        $fontFamily = 'Times';
        $fontSize = 9;

        // Store Y pos before writing everything
        $currentYPos = $mpdf->y;

        // If isSender is false, then move x to the recipient info field
        if (is_bool($isSender)) {
            $mpdf->SetFont('Helvetica', 'BU', $fontSize + 3);

            if ($isSender) {
                $mpdf->WriteCell($cellWidth, $cellHeight + 3, 'QUOTATION FROM', 'B', 2);
            }
            else {
                $mpdf->SetX($mpdf->x + 95);
                $mpdf->WriteCell($cellWidth, $cellHeight + 3, 'QUOTATION TO', 'B', 2);
            }
        }

        // Name, in bold
        $mpdf->SetFont($fontFamily, 'B', $fontSize);
        $mpdf->WriteCell($cellWidth, $cellHeight, $data['name'], $border, 2);

        // Address
        $mpdf->SetFont($fontFamily, '', $fontSize - 1);
        $tmpX = $mpdf->x;
        $mpdf->MultiCell($cellWidth, $cellHeight, $data['addr'], $border);
        $mpdf->SetX($tmpX);

        // Phone
        $mpdf->WriteCell($cellWidth, $cellHeight, $data['phone'], $border, 2);

        // Email
        $mpdf->WriteCell($cellWidth, $cellHeight, $data['email'], $border, 1);

        // Return the previous Y pos before calling this function
        return $currentYPos;
    }

    /**
     * Fill the items table.
     *
     * This function accepts the data (name, qty, price) to be written
     * in the table.
     *
     * @param MPDF $mpdf: MPDF object
     * @param array $data: Items
     *
     * @return float $endTableYPos: Y position after filling the items table
     */
    private static function writeItems($mpdf, $data) {
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
        for ($i = 0; $i < count($data); $i++) {
            $startY = $mpdf->y;

            // Item name
            $mpdf->SetX($mpdf->x + $itemNumCellWidth);
            // Get current position before calling MultiCell()
            $x = $mpdf->x;
            $y = $mpdf->y;
            $mpdf->MultiCell($nameCellWidth, $nameCellHeight, $data[$i]['name'], 'TLB');
            $nameActualCellHeight = $mpdf->y;   // Get current Y position after calling MultiCell()

            // Item quantity
            // Set current position to correct position before calling WriteCell()
            $mpdf->SetXY($x + $nameCellWidth, $y);
            $mpdf->WriteCell($quantityCellWidth, $nameActualCellHeight - $mpdf->y, strval($data[$i]['quantity']), 'TLB', 0, 'C');

            // Unit price
            $mpdf->WriteCell($uPriceCellWidth, $nameActualCellHeight - $mpdf->y, 'Rp. ' . number_format($data[$i]['price']), 'TLB', 0, 'R');

            // Total price
            $totalPrice = $data[$i]['price'] * $data[$i]['quantity'];   // Calculate the total price(unit price * quantity)
            $mpdf->WriteCell($tPriceCellWidth, $nameActualCellHeight - $mpdf->y, 'Rp. ' . number_format($totalPrice), 'TLRB', 1, 'R');

            // Item number
            $mpdf->SetY($startY);
            $mpdf->WriteCell($itemNumCellWidth, $nameActualCellHeight - $mpdf->y, strval($i + 1), 'TLB', 0, 'C');

            // Set the position for the next item to be written to the table in the template
            $mpdf->SetY($nameActualCellHeight);
        }

        // Return the Y position after filling the items table
        return $mpdf->y;
    }

    /**
     * Writes the subtotal, tax, and grand total.
     *
     * This function accepts the data of items and tax rate.
     * The function will take prices from all items to calculate the subtotal,
     * then the tax rate will be used to calculate the grand total.
     *
     * @param object $mpdf: MPDF object
     * @param array $data: Items
     * @param int $taxRate: Tax rate
     *
     * @return int grandTotal: Grand total
     */
    private static function writeTotal($mpdf, $data, $taxRate) {
        // Write Cell max width and height
        $cellWidth = 30;
        $cellHeight = 4.5;

        // Font family and size
        $fontFamily = 'Helvetica';
        $fontSize = 8;

        // Calculate the sub total (total without tax)
        $subtotal = 0;
        for ($i = 0; $i < count($data); $i++) {
            $subtotal += $data[$i]['price'] * $data[$i]['quantity'];
        }

        // Calculate the grand total (sub total with tax)
        $tax = intval($subtotal * ($taxRate / 100));
        $grandtotal = $subtotal + $tax;

        // Write the sub total (sum of all number from Total Price)
        $mpdf->SetFont('Arial', 'B', 9);
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Sub-total', '1', 0, 'R');
        $mpdf->SetFont($fontFamily, '', $fontSize);
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Rp. ' . number_format($subtotal), 1, 2, 'R');

        // Write tax rate and calculated tax
        $mpdf->SetX($mpdf->x - $cellWidth);
        $mpdf->SetFont('Arial', 'B', 9);
        $mpdf->WriteCell($cellWidth, $cellHeight, 'PPN (' . $taxRate . '%)', 1, 0, 'R');
        $mpdf->SetFont($fontFamily, '', $fontSize);
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Rp. ' . number_format($tax), 1, 2, 'R');

        // Write the grand total (sub total with tax)
        $mpdf->SetX($mpdf->x - $cellWidth);
        $mpdf->SetFont('Arial', 'B', 9);
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Total', 1, 0, 'R');
        $mpdf->SetFont($fontFamily, 'B', $fontSize);    // Make it bold
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Rp. ' . number_format($grandtotal), 1, 2, 'R');

        // Return the grand total
        return $grandtotal;
    }

    /**
     * Writes the grandtotal in words to the PDF
     *
     * This function accepts the grand total in number.
     * Then, it will call convertNumberToWord() to convert the numbers to words.
     * This function will then write the words to the PDF.
     *
     * @param object $mpdf: MPDF object
     * @param int $total: Total price amount
     * @param int $border: Border value
     *
     * @return void
     */
    private static function writeTotalInWords($mpdf, $total, $border) {
        // Write Cell max width and height
        $cellWidth = 12;
        $cellHeight = 5;

        // Font family and size
        $fontFamily = 'Helvetica';
        $fontSize = 10;

        // Spell out the total in words
        $text = strtoupper(PDF::convertNumberToWord($total)) . ' RUPIAH';
        $text = preg_replace('/\s+/', ' ', $text);  // Remove excess spaces

        // Write total in words
        $mpdf->SetFont($fontFamily, '', $fontSize);
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Total: ', $border, 0);
        $mpdf->SetFont('', 'B');
        $mpdf->MultiCell(0, $cellHeight, $text, $border);
    }

    /**
     * Write terms and conditions field

     * This function accepts an array of string. It will
     * write all strings in the array to the PDF, specifically
     * in the Terms & Conditions field.
     *
     * @param object $mpdf: MPDF object
     * @param array $termsConditions: Array of strings, containing terms and conditions
     * @param int $border: Border value
     *
     * @return void
     */
    private static function writeTermsConditions($mpdf, $text, $border) {
        // Write Cell max width and height
        $cellWidth = 46;
        $cellHeight = 6;

        // Font family and size
        $fontFamily = 'Helvetica';
        $fontSize = 10;

        // Show cells border. 1 for yes, 0 for no
        $border = 0;

        // Write terms and conditions
        $mpdf->SetFont($fontFamily, 'B', $fontSize + 3);
        $mpdf->WriteCell($cellWidth, $cellHeight, 'Syarat & Ketentuan', 'B', 2);

        $mpdf->SetFont($fontFamily, '', $fontSize);
        for ($i = 0; $i < count($text); $i++) {
            $mpdf->WriteCell(5, $cellHeight, $i + 1 . '. ', $border, 0);
            $mpdf->MultiCell(0, $cellHeight, $text[$i], $border);
        }
    }

    /**
     * Write best regards field

     * This function accepts a string. It will
     * write the string to the PDF, specifically
     * in the Best Regards field.
     *
     * @param object $mpdf: MPDF object
     * @param array $data: Array of strings, containing sender data
     * @param int $border: Border value
     *
     * @return void
     */
    private static function writeBestRegards($mpdf, $data, $border) {
        // Write Cell max height
        $cellHeight = 5.2;

        // Font family and size
        $fontFamily = 'Helvetica';
        $fontSize = 10.5;

        // Write sender info
        // Name
        $mpdf->SetFont($fontFamily, 'B', $fontSize);
        $mpdf->WriteCell(0, $cellHeight, 'Hormat kami,', $border, 2);
        $mpdf->SetFont('', '');
        $mpdf->WriteCell(0, $cellHeight, $data['person'], $border, 2);
        $mpdf->WriteCell(0, $cellHeight, $data['name'], $border, 2);

        // Email
        $mpdf->WriteCell(0, $cellHeight, $data['email'], $border, 2);

        // Phone
        $mpdf->WriteCell(0, $cellHeight, $data['phone'], $border, 2);
    }

    /**
     * Write bank details field

     * This function accepts an array of string. It will
     * write all strings in the array to the PDF, specifically
     * about the bank details of the sender.
     *
     * @param object $mpdf: MPDF object
     * @param array $data: Array of strings, containing bank details data
     *
     * @return void
     */
    private static function writeBankDetails($mpdf, $data) {
        // Write Cell max height
        $cellHeight = 5.2;

        // Font family and size
        $fontFamily = 'Helvetica';
        $fontSize = 10.5;

        // Write bank details
        $mpdf->SetFont($fontFamily, 'B', $fontSize);
        $mpdf->WriteCell(0, $cellHeight, 'Pembayaran melalui transfer bank', 0, 2);
        $mpdf->SetFont('', '');
        foreach ($data as $bank) {
            $mpdf->WriteCell(0, $cellHeight, $bank['institution'], 0, 2);
            $mpdf->WriteCell(0, $cellHeight, 'A/N ' . $bank['accountName'], 0, 2);
            $mpdf->WriteCell(0, $cellHeight, $bank['accountNumber'], 0, 2);
            $mpdf->WriteCell(0, $cellHeight, '', 0, 2);
        }
    }

    /**
     * Draw boxes for the sender and recipient data fields.
     *
     * Just the boxes. No text.
     *
     * @param object $mpdf: MPDF object
     *
     * @return float: Y position after drawing the boxes
     */
    private static function drawSenderRecipientBoxes($mpdf) {
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

        // Return the Y position after drawing the boxes
        return $mpdf->y + $rectHeight;
    }

    /**
     * Quotation number builder.
     *
     * Accepts the number in key-value pairs and
     * formatting for separating between values
     *
     * @param array $data: Array of key-value pairs for quote number
     * @param string $separator: Separator between values
     *
     * @return string: Formatted quote number
     */
    private static function buildQuoteNumber($number, $format = '/') {
        // Combine everything in $number into one string with specified format
        $combinedString =
            $number['year'] . $format .
            $number['division'] . $format .
            $number['sales'] . $format .
            $number['month'] . $format .
            $number['number'];

        return $combinedString;
    }

    /**
     * Draw item table header. Without rows.
     *
     * @param object $mpdf: MPDF object
     *
     * @return float: X position of unit price column
     */
    private static function drawItemTable($mpdf) {
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

        // Return the X position of unit price column
        return $uPriceXPos;
    }

    /**
     * Add attachment to PDF as extra pages
     *
     * @param object $mpdf: MPDF object
     * @param string $file: Path to file
     *
     * @return void
     */
    private static function addAttachment($mpdf, $file) {
        // Select the source file to be added as attachment
        // SetSourceFile() returns the number of pages of the source file
        if ($file) {
            $template = $mpdf->setSourceFile($file);

            // Import the selected source file above
            for ($i = 0; $i < $template; $i++) {
                $fileId = $mpdf->importPage($i + 1);
                $mpdf->SetPageTemplate($fileId);

                if ($i < $template) {
                    $mpdf->AddPage();
                }
            }
        }
    }

    /** Convert input number to words.
     *
     * Translated version of a nice function I found on Stackoverflow:
     * (https://stackoverflow.com/questions/11500088/php-express-number-in-words)
     * Answer by Shahbaz
     *
     * This function accepts number, and it will convert
     * the input number to words
     *
     * @param int $number: Number to be converted
     *
     * @return string: Number in words
     */
    private static function convertNumberToWord($num = false) {
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas',
            'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'
        );
        $list2 = array('', 'sepuluh', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh', 'ratus');
        $list3 = array('', 'ribu', 'juta', 'miliar', 'triliun', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            if ($list1[$hundreds] == 'satu') {
                $hundreds = ' seratus';
            }
            else {
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' ratus' . ' ' : '');
            }
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }
}
