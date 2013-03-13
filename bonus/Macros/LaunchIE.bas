Attribute VB_Name = "LaunchIE"
' Lifted code from experts-exchange

Private Declare Function FindExecutable Lib "shell32.dll" Alias "FindExecutableA" (ByVal lpFile As String, ByVal lpDirectory As String, ByVal lpResult As String) As Long

Private Function TrimNull(startstr As String) As String
Dim pos As Integer
 pos = InStr(startstr, Chr$(0))
 If pos Then
    TrimNull = Left$(startstr, pos - 1)
    Exit Function
 End If
   TrimNull = startstr
End Function

Public Sub LaunchURL(urlAddress As String)
Dim strEXE As String * 255
Dim ff As Integer
ff = FreeFile
Open "C:\Tmp.htm" For Output As #ff: Close #ff
Call FindExecutable("C:\Tmp.htm", "", strEXE)
Shell TrimNull(strEXE) & Space$(1) & urlAddress, vbMaximizedFocus
Kill "C:\Tmp.htm"
End Sub

' usage
Private Sub Command1_Click()
LaunchURL "http://localhost/"
End Sub

Public Sub CreateForm(ArticleText, ArticlePullQuote, ArticleDate)

    Set objDoc = Documents.Open(FileName:="C:\phpdev\www\admin\article_template.php", Format:=wdOpenFormatText)
    With Selection.Find
    .ClearFormatting
    .Text = "VBDate"
    .Replacement.ClearFormatting
    .Replacement.Text = ArticleDate
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceAll
    End With
    
    With Selection.Find
    .ClearFormatting
    .Text = "VBText"
    '.Replacement.ClearFormatting
    '.Replacement.Text = ArticleText
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceNone
    End With
    Selection.TypeText ArticleText
    
    With Selection.Find
    .ClearFormatting
    .Text = "VBPullQuote"
    '.Replacement.ClearFormatting
    '.Replacement.Text = ArticleText
    .Execute Forward:=False, _
        Wrap:=wdFindContinue, Replace:=wdReplaceNone
    End With
    Selection.TypeText ArticlePullQuote
    
    Application.ActiveDocument.SaveAs FileName:="C:\phpdev\www\admin\article.php", FileFormat:=wdOpenFormatText
    objDoc.Close (wdDoNotSaveChanges)
    
    LaunchURL "http://localhost/admin/article.php?type=addFromWord"

End Sub


