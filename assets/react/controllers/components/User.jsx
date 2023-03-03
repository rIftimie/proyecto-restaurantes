import React from "react";
import { getUsers } from "../../Api/Users";
import React, { useEffect, useState } from "react";

const User = () => {

    const [users, setUsers] = useState([]);
    useEffect(() => {
        getUsers()
            .then((json) => setUsers(json));
    }, []);

    return (
        <div>
            {users.map((user) => (
                <div key={user.id}>
                    <p>{user.name}</p>
                    <p>{user.email}</p>
                </div>
            ))}
            <p>{users}</p>
        </div>
    );
};



export default User;