Attribute VB_Name = "Changeae01"
' This method runs through the yyyy_mm_dd directories and applies a file search and replace to each file in it.
' Potentially very dangerous.  Be careful.

Sub ChangeAe01()

    With Dialogs(wdDialogFileOpen)
        .Display
        tmpStr = Application.Options.DefaultFilePath(wdCurrentFolderPath)
        tmpStr2 = .Name
    End With


    With Application.FileSearch
        .LookIn = tmpStr
        .FileType = msoFileTypeAllFiles
        .Execute
        For intCounter = 1 To .FoundFiles.Count
            theFile = .FoundFiles(intCounter)
            Set objDoc = Documents.Open(FileName:=theFile, Format:=wdOpenFormatText)
        Selection.Find.ClearFormatting
        Selection.Find.Replacement.ClearFormatting
        With Selection.Find
            .Text = "include(""../article.php"");"
            .Forward = True
            .Wrap = wdFindContinue
            .MatchCase = False
            .MatchWholeWord = False
            .MatchWildcards = False
            .MatchSoundsLike = False
            .MatchAllWordForms = False
            .Wrap = wdFindStop
            .Replacement.ClearFormatting
            .Replacement.Text = "include(""date.php"");" & Chr(13) & "include(""../article.php"");"
        End With
        Selection.Find.Execute Replace:=wdReplaceAll
        objDoc.Close SaveChanges:=wdSaveChanges
        
        Next intCounter
        
    End With
                

End Sub

