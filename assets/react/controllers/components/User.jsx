import React, { useEffect, useState } from "react";
import { getUsers } from "../Api/Users";

const User = () => {

    const [users, setUsers] = useState([]);
    // console.log(getUsers());
    useEffect(() => {
        getUsers()
            .then((json) => setUsers(json))
    }, []);

    
    return (
        <div>
            {users.map((user) => (
                <div key={user.id}>
                    
                    <p>Name: {user.username}</p>
                    {/* <p>{user.email}</p> */}
                </div>
            ))}
            {/* <p>{users}</p> */}
        </div>
    );
};



export default User;