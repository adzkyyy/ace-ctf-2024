box.cfg{}

if not box.space.users then
    space = box.schema.space.create('users', {
      engine = 'memtx', -- or 'vinyl' depending on your use case
      if_not_exists = true
    })
  
    -- Define the format for the 'users' space
    space:format({
      { name = 'id',                           type = 'unsigned' },
      { name = 'username',                     type = 'string' },
      { name = 'xp',                           type = 'unsigned' },
      { name = 'role',                         type = 'string' },
      { name = 'is_active',                    type = 'boolean' },
    })

    space:create_index('primary', { type = 'tree', parts = { 1, 'unsigned' } })
    space:create_index('username', { type = 'tree', parts = { 2, 'string' } })
end

-- Insert data into the 'users' space
space:insert{1, 'administrator', 99999, 'admin', true}
space:insert{2, 'msfir', 0, 'pwn', true}
space:insert{3, 'rootkits', 0, 'webex', true}
space:insert{4, 'k.eii', 0, 'forensics', true}
space:insert{5, 'wrth', 0, 'crypto', true}
space:insert{6, 'dimas', 0, 'proxss', true}
space:insert{7, 'zanark', 0, 'reverse', true}
space:insert{8, 'rorre', 0, 'hacker', true}
space:insert{9, 'h4ck3r', 0, 'hacker', true}
space:insert{10, 'h4x0r', 0, 'hacker', true}
space:insert{11, 'bjorka', 0, '?????', true}
space:insert{12, 'mulyono', 0, 'hacker?', true}
space:insert{13, 'yqroo', 0, 'yono warga sekitar', true}