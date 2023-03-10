import React, { useEffect, useState } from "react";
import { getTables } from "../Api/Tables";

const Table = () => {

    const [tables, setTables] = useState([]);
    useEffect(() => {
        getTables()
            .then((json) => setTables(json));
    }, []);

    return (
        <div>
            {tables.map((table) => (
                <div key={user.id}>
                    <p>{table.number}</p>
                    {/* <p>{user.email}</p> */}
                </div>
            ))}
            {/* <p>{users}</p> */}
        </div>
    );
};
export default Table;