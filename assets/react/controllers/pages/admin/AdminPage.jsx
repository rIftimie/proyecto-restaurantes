import React from 'react';
import Header from '../../components/Header/Header';
import { useState } from 'react';
import User from '../../components/User';
import Orders from '../../components/Order';

const AdminPage = () => {
  const [componente, setComponente] = useState(null);
  return (
    <div>
      <h1>Admin Panel</h1>
      <Header setcomponente={setComponente}  />
      {componente === "User" && <User />}
      {componente === "Orders" && <Orders />}
    </div>
  );
}

export default AdminPage;