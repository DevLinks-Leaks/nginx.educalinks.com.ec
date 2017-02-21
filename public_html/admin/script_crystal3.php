<?php

//- Variables - for your RPT and PDF
//echo "Print Report Test";
$my_report = "C:\\inetpub\wwwroot\\IngeniumAcad\\reportes\\test.rpt"; //rpt source file
$my_pdf = "C:\\inetpub\wwwroot\\IngeniumAcad\\reportes\\test.pdf"; // RPT export to pdf file
//-Create new COM object-depends on your Crystal Report version
$ObjectFactory= new COM("CrystalReports115.ObjectFactory.1") or die ("Error on load"); // call COM port
$crapp = $ObjectFactory-> CreateObject("CrystalDesignRunTime.Application"); // create an instance for Crystal
$creport = $crapp->OpenReport($my_report, 1); // call rpt report

// to refresh data before

//- Set database logon info - must have
$creport->Database->Tables(1)->SetLogOnInfo("192.168.137.51\MSSQLSERVER2008", "Ingenium_Acad", "sa", "R3dlink5");

//- field prompt or else report will hang - to get through
$creport->EnableParameterPrompting = 0;

//- DiscardSavedData - to refresh then read records
$creport->DiscardSavedData;
$creport->ReadRecords();

//------ Pass formula fields --------
$creport->FormulaFields->Item(1)->Text = ("'My Report Title'");
$creport->ParameterFields(1)->AddCurrentValue (175);
   
//export to PDF process
$creport->ExportOptions->DiskFileName=$my_pdf; //export to pdf
$creport->ExportOptions->PDFExportAllPages=true;
$creport->ExportOptions->DestinationType=1; // export to file
$creport->ExportOptions->FormatType=31; // PDF type
$creport->Export(false);

//------ Release the variables ------
$creport = null;
$crapp = null;
$ObjectFactory = null;

//------ Embed the report in the webpage ------
print "<embed src=\"C:\\inetpub\wwwroot\\IngeniumAcad\\reportes\\test.pdf\" width=\"100%\" height=\"100%\">"

   
   
?>