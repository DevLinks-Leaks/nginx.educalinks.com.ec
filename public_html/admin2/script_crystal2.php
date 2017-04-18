<?php
//------  Variables ------
$my_report = "C:\\inetpub\\wwwroot\\test\\test.rpt";  //This must be the full path to the file
$my_pdf = "C:\\inetpub\\wwwroot\\test\\test.pdf";

//------ Create a new COM Object of Crytal Reports 10 ------
$ObjectFactory= new COM("CrystalReports.ObjectFactory.2");

//------ Create a instance of library Application -------
$crapp = $ObjectFactory->CreateObject("CrystalRuntime.Application.9");

//------ Open your rpt file ------
$creport = $crapp->OpenReport($my_report, 1);

//------ Set database logon info ------
$creport->Database->Tables(1)->SetLogOnInfo("192.168.137.51\MSSQLSERVER2008", "Ingenium_Acad", "sa", "R3dlink5");

//------ Suppress the Parameter field prompt or else report will hang ------
$creport->EnableParameterPrompting = 0;

//------ DiscardSavedData make a Refresh in your data -------
$creport->DiscardSavedData;
$creport->ReadRecords();

//------ Pass formula fields --------
//$creport->FormulaFields->Item(1)->Text = ("'My Report Title'");
$creport->ParameterFields(1)->AddCurrentValue (175);
//$creport->ParameterFields(2)->AddCurrentValue (2000);

//------ Export to PDF -------
$creport->ExportOptions->DiskFileName=$my_pdf;
$creport->ExportOptions->FormatType=31;
$creport->ExportOptions->DestinationType=1;
$creport->Export(false);

//------ Release the variables ------
$creport = null;
$crapp = null;
$ObjectFactory = null;

//------ Embed the report in the webpage ------
?>
<embed src="test.pdf" width="100%" height="100%">