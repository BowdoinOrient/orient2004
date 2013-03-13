Attribute VB_Name = "NewMacros"
Dim ItalicsChanged As Boolean
Dim EntersChanged As Boolean
Dim SomethingSelected As Boolean

Sub init()

    ItalicsChanged = False
    EntersChanged = False

End Sub

Sub TestMe()


End Sub

Sub CopyArticlePullQuote()
    SomethingSelected = False
    If (Selection.Characters.Count > 1) Then
        SomethingSelected = True
        Selection.Copy
    End If

End Sub

Function GetArticlePullQuote()

If (SomethingSelected = False) Then
    GetArticlePullQuote = " "
Else

Documents.Add DocumentType:=wdNewBlankDocument
Selection.Paste

Call ReplaceItalicsWithITags
Call ReplaceFunnyCharsWithCharCodes

theText = Application.ActiveDocument.Content.Text

Application.ActiveDocument.Close (wdDoNotSaveChanges)

GetArticlePullQuote = theText

End If

End Function

Function GetArticleText()
    
    'With Dialogs(wdDialogFileOpen)
    '    .Display
    '    tmpStr = Application.Options.DefaultFilePath(wdCurrentFolderPath)
    '    tmpStr2 = .Name
    'End With


    'With Application.FileSearch
    '    .LookIn = tmpStr
    '    .FileType = msoFileTypeWordDocuments
    '    .Execute
    '    For intCounter = 1 To .FoundFiles.Count
    '        theFile = .FoundFiles(intCounter)
    '        Set objDoc = Documents.Open(FileName:=theFile)
    
            'Save the document if they want to.
            'If Not Application.ActiveDocument.Saved Then
            '    If MsgBox("Do you want to save changes?", vbYesNo, "Prompt") = vbYes Then
            '        Application.ActiveDocument.Save
            '    End If
            'End If

            
            Call ReplaceItalicsWithITags
            Call ReplaceEntersWithPTags
            Call ReplaceFunnyCharsWithCharCodes
            'Call ReplaceQuotesWithEscapeChars
            
            
            theText = Application.ActiveDocument.Content.Text
            
            Application.ActiveDocument.Close (wdDoNotSaveChanges)
            
            GetArticleText = theText
            
            'Save and close the file and loop back.
            'splitIt = Split(theFile, ".")
            'htmlFileName = splitIt(0) & ".html.doc"
            'objDoc.SaveAs FileName:=htmlFileName
    '        objDoc.Close
    '    Next intCounter
    'End With
End Function


Sub ReplaceItalicsWithITags()

Selection.EndKey Unit:=wdStory

Dim LastReplaced As Integer

ContinueLoop = True

While ContinueLoop = True

    LastReplaced = Selection.Range.Start

    Selection.Find.ClearFormatting
    Selection.Find.Font.Italic = True
    Selection.Find.Replacement.ClearFormatting
    With Selection.Find
        .Text = ""
        .Forward = False
        .Wrap = wdFindContinue
        .Format = True
        .MatchCase = False
        .MatchWholeWord = False
        .MatchWildcards = False
        .MatchSoundsLike = False
        .MatchAllWordForms = False
        .Wrap = wdFindStop
    End With
    Selection.Find.Execute
    
    ContinueLoop = Selection.Range.Start <> LastReplaced
    
    If (ContinueLoop) Then
        Selection.Font.Italic = False
        Selection.TypeText "<i>" & Selection.Text & "</i>"
    End If

Wend

End Sub

Sub ReplaceFunnyCharsWithCharCodes()


With Selection.Find
    .ClearFormatting
    .Text = "—"
    .Replacement.ClearFormatting
    .Replacement.Text = "&#151;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "é"
    .Replacement.ClearFormatting
    .Replacement.Text = "&eacute;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "è"
    .Replacement.ClearFormatting
    .Replacement.Text = "&egrave;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "à"
    .Replacement.ClearFormatting
    .Replacement.Text = "&agrave;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "á"
    .Replacement.ClearFormatting
    .Replacement.Text = "&aacute;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "ñ"
    .Replacement.ClearFormatting
    .Replacement.Text = "&ntilde;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "ó"
    .Replacement.ClearFormatting
    .Replacement.Text = "&oacute;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "ò"
    .Replacement.ClearFormatting
    .Replacement.Text = "&ograve;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "ù"
    .Replacement.ClearFormatting
    .Replacement.Text = "&ugrave;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "ú"
    .Replacement.ClearFormatting
    .Replacement.Text = "&uacute;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

With Selection.Find
    .ClearFormatting
    .Text = "ç"
    .Replacement.ClearFormatting
    .Replacement.Text = "&ccedil;"
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

'    With Selection.Find
'        .Text = "’"
'        .Replacement.Text = "\'"
'        .Forward = False
'        .Wrap = wdFindContinue
'        .Format = False
'        .MatchCase = False
'        .MatchWholeWord = False
'        .MatchWildcards = False
'        .MatchSoundsLike = False
'        .MatchAllWordForms = False
'    End With
'    Selection.Find.Execute Replace:=wdReplaceAll

End Sub

Sub ReplaceEntersWithPTags()

theP = "<p align=" & Chr(34) & "left" & Chr(34) & ">"

Selection.HomeKey Unit:=wdStory
Selection.TypeText (theP)


Selection.EndKey Unit:=wdStory

LastReplaced = 0

While Selection.Range.Start <> LastReplaced

LastReplaced = Selection.Range.Start

With Selection.Find
    .ClearFormatting
    .Text = Chr(13)
    .Replacement.ClearFormatting
    .Replacement.Text = "helllo"
    .Execute Forward:=False, _
        Wrap:=wdFindStop, Replace:=wdReplaceOne
End With

Wend

Call RemDup

Call ChangeHellloToP

Selection.EndKey Unit:=wdStory
Selection.TypeText ("</p>")

End Sub

Sub RemDup()

For i = 1 To 100

With Selection.Find
    .ClearFormatting
    .Text = "helllohelllo"
    .Replacement.ClearFormatting
    .Replacement.Text = "helllo"
    .Execute Forward:=True, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
End With

Next i

End Sub

Sub ChangeHellloToP()

theP = "</p>" & Chr(13) & "<p align=" & Chr(34) & "left" & Chr(34) & ">"

With Selection.Find
    .ClearFormatting
    .Text = "helllo"
    .Replacement.ClearFormatting
    .Replacement.Text = theP
    .Execute Replace:=wdReplaceAll, Forward:=True, _
        Wrap:=wdFindContinue
End With

End Sub
Sub Macro1()
Attribute Macro1.VB_Description = "Macro recorded 9/29/2003 by Belinda Lovett"
Attribute Macro1.VB_ProcData.VB_Invoke_Func = "Normal.NewMacros.Macro1"

    Selection.Find.ClearFormatting
    Selection.Find.Replacement.ClearFormatting
    With Selection.Find
        .Text = "'"
        .Replacement.Text = "\'"
        .Forward = False
        .Wrap = wdFindAsk
        .Format = False
        .MatchCase = False
        .MatchWholeWord = False
        .MatchWildcards = False
        .MatchSoundsLike = False
        .MatchAllWordForms = False
    End With
    Selection.Find.ClearFormatting
    Selection.Find.Replacement.ClearFormatting
    With Selection.Find
        .Text = "'"
        .Replacement.Text = "\'"
        .Forward = False
        .Wrap = wdFindAsk
        .Format = False
        .MatchCase = False
        .MatchWholeWord = False
        .MatchWildcards = False
        .MatchSoundsLike = False
        .MatchAllWordForms = False
    End With
    Selection.Find.ClearFormatting
    Selection.Find.Replacement.ClearFormatting
    With Selection.Find
        .Text = "’"
        .Replacement.Text = "\'"
        .Forward = False
        .Wrap = wdFindAsk
        .Format = False
        .MatchCase = False
        .MatchWholeWord = False
        .MatchWildcards = False
        .MatchSoundsLike = False
        .MatchAllWordForms = False
    End With
    Selection.Find.Execute Replace:=wdReplaceAll
End Sub
Sub Macro2()
Attribute Macro2.VB_Description = "Macro recorded 10/2/2003 by Belinda Lovett"
Attribute Macro2.VB_ProcData.VB_Invoke_Func = "Normal.NewMacros.Macro2"
'
' Macro2 Macro
' Macro recorded 10/2/2003 by Belinda Lovett
'
    Selection.Find.ClearFormatting
    With Selection.Find
        .Text = """"
        .Replacement.Text = "../section.php"
        .Forward = True
        .Wrap = wdFindContinue
        .Format = False
        .MatchCase = False
        .MatchWholeWord = False
        .MatchWildcards = False
        .MatchSoundsLike = False
        .MatchAllWordForms = False
    End With
    Selection.Find.Execute
End Sub
Sub AutoExec()
Attribute AutoExec.VB_Description = "Macro created 10/22/2003 by Belinda Lovett"
Attribute AutoExec.VB_ProcData.VB_Invoke_Func = "Normal.NewMacros.AutoExec"
'
' AutoExec Macro
' Macro created 10/22/2003 by Belinda Lovett
'

End Sub
Sub Macro3()
Attribute Macro3.VB_Description = "Macro recorded 5/3/2004 by Belinda Lovett"
Attribute Macro3.VB_ProcData.VB_Invoke_Func = "Normal.NewMacros.Macro3"
'
' Macro3 Macro
' Macro recorded 5/3/2004 by Belinda Lovett
'
    Application.Browser.Target = wdBrowseEdit
    Application.Browser.Previous
    Selection.Find.ClearFormatting
    With Selection.Find
        .Text = "—"
        .Replacement.Text = "&ccedil;"
        .Forward = False
End Sub
