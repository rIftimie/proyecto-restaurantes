import React from 'react';
import Header from '../../controllers/components/Header/Header';
import { useState } from 'react';
import User from '../../controllers/components/User';

const AdminPages = () => {
  const [componente, setComponente] = useState(null);

  return (
    <div>
      <h1>Admin Panel</h1>
      <Header setcomponente={setComponente}  />
      {componente === "User" && <User />}
    </div>
  );
};

export default AdminPages;