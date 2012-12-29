function _CreateMutex(lpMutexAttributes: PSecurityAttributes;
  bInitialOwner: Integer; lpName: PChar): THandle; stdcall; external kernel32 name 'CreateMutexA';