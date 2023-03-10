import React from 'react';
import Header from '../../components/Header/Header';
import { useState } from 'react';
import User from '../../components/User';
import Table from '../../components/Table';

const AdminPage = () => {
  const [componente, setComponente] = useState(null);
  return (
    <div>
      <h1>Admin Panel</h1>
      <Header setcomponente={setComponente}  />
      {componente === "User" && <User />}
      {componente === "Table" && <Table />}
    </div>
  );
}

export default AdminPage;