const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    // Read the URL from the command line argument
    const url = process.argv[2];
    const id = process.argv[3];
	// Listen for console messages
    page.on('console', message => console.log('Console: ${message.text()}'));

    // Navigate to the specified URL
    await page.goto(url, { waitUntil: 'networkidle0' });

	// Generate PDF
	const pdfPath = 'pdf/output_'+id+'.pdf';
    await page.pdf({
        path: pdfPath,
        format: 'A4'
    });

    await browser.close();
})();
