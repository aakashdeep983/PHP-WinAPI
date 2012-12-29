unit ProcessWork;

interface

uses Windows, SysUtils, Classes, TlHelp32, Constants;
const
  SUCCESS = 0;
type
  TProcess = class
  private
    FProcessHandle: LongWord;
    FProcessPID: DWORD;
    function GetBaseAddress(): DWORD;
  public
    procedure SelectProcess(PID: DWORD);
    function ReadProcessData(Offset: DWORD; var Buffer; Size: SIZE_T): SIZE_T;
    function WriteProcessData(Offset: DWORD; const Buffer; Size: SIZE_T): SIZE_T;

    function ReadProcess<T>(Offset: DWORD): T;

    function ReadInt(Offset: DWORD): INT;
    function ReadUInt(Offset: DWORD): UINT;
    function ReadUInt64(Offset: DWORD): UINT64;
    function ReadFloat(Offset: DWORD): FLOAT;
    function ReadString(Offset: DWORD): String;



    function GetProcessList(WindowName: String):TStringList;

    property ProcessPID: DWORD read FProcessPID;
    property BaseAddress: DWORD read GetBaseAddress;

    destructor Destroy;override;
  end;


implementation

function TProcess.GetProcessList(WindowName: String):TStringList;
var
    Wd : HWnd;
    PID: DWORD;
    WindowTitle: PChar;
begin
    result:=TStringList.Create;
    GetMem(WindowTitle, 256);
    Wd:=FindWindow(nil, nil);
    while (Wd<>0) do
    begin
      GetWindowText(Wd, WindowTitle, 256);
      if(WindowName=String(WindowTitle))then
        begin
          GetWindowThreadProcessId(Wd, @PID);
          result.Add(IntToStr(PID));
        end;
      Wd:=GetNextWindow(Wd,GW_HWNDNEXT);
    end;
    FreeMem(WindowTitle);
end;

procedure TProcess.SelectProcess(PID: DWORD);
begin
  CloseHandle(FProcessHandle);
  self.FProcessPID := PID;
  self.FProcessHandle := OpenProcess(PROCESS_ALL_ACCESS, False, PID);
end;

function TProcess.ReadProcessData(Offset: DWORD; var Buffer; Size: SIZE_T): SIZE_T;
begin
  ReadProcessMemory( FProcessHandle, ptr(Offset), @Buffer, Size, result);
end;

function TProcess.ReadInt(Offset: DWORD): INT;
begin
  self.ReadProcessData(Offset, result, Constants.SIZE_INT);
end;

function TProcess.ReadUInt(Offset: DWORD): UINT;
begin
  self.ReadProcessData(Offset, result, Constants.SIZE_UINT);
end;

function TProcess.ReadUInt64(Offset: DWORD): UINT64;
begin
  self.ReadProcessData(Offset, result, Constants.SIZE_UINT64);
end;


function TProcess.ReadFloat(Offset: DWORD): FLOAT;
begin
  self.ReadProcessData(Offset, result, Constants.SIZE_FLOAT);
end;

function TProcess.ReadString(Offset: DWORD): String;
const
  READ_BLOCK = 64;
type
  TBuffer = array[0..READ_BLOCK-1] of char;
var StrBuff: TBuffer;
    UTF8Str: RawByteString;
    function ReadBuffer(Offset: DWORD): TBuffer;
    begin

    end;
begin
//      UTF8Str := UTF8Encode(ReadBuffer(Offset));
//
//      for (int i = 1; utfbs.IndexOf('\0') == -1; i++)
//      {
//          utfbs = utfbs + Encoding.UTF8.GetString(ReadBytes((IntPtr)(IntPtr.Add(address, (i * offset))), offset));
//      }
//      ret = (string)utfbs.Remove(utfbs.IndexOf('\0'));
//
//      return (T)ret;

end;

function TProcess.WriteProcessData(Offset: DWORD; const Buffer; Size: SIZE_T): SIZE_T;
begin
  WriteProcessMemory(FProcessHandle, ptr(Offset), @Buffer, Size, result);
end;


function TProcess.ReadProcess<T>(Offset: DWORD): T;
begin

end;

function TProcess.getBaseAddress():DWORD;
var snap: THandle;
    moduleEn: MODULEENTRY32W;
begin
  result:=0;
  snap:=CreateToolhelp32Snapshot(TH32CS_SNAPMODULE, self.FProcessPID);
  moduleEn.dwSize := SizeOf(MODULEENTRY32W);
  if Module32FirstW(snap, moduleEn) then
    result:=DWORD(moduleEn.modBaseAddr);
end;

destructor TProcess.Destroy;
begin
  CloseHandle(FProcessHandle);
  inherited Destroy;
end;

end.

