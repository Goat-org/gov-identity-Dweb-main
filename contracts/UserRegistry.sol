pragma solidity ^0.5.16;

contract UserRegistry {
    struct User {
        string firstName;
        string surname;
        string email;
        bytes32 passwordHash;
    }

    mapping(address => User) public users;

    event UserRegistered(address userAddress, string email);

    // Register a new user
    function registerUser(
        string memory _firstName, 
        string memory _surname, 
        string memory _email, 
        bytes32 _passwordHash
    ) 
        public 
    {
        require(bytes(users[msg.sender].email).length == 0, "User already registered");
        
        users[msg.sender] = User(_firstName, _surname, _email, _passwordHash);
        emit UserRegistered(msg.sender, _email);
    }

    // Login user by checking email and password hash
    function loginUser(string memory _email, bytes32 _passwordHash) public view returns (bool) {
        User memory user = users[msg.sender];
        return (
            keccak256(abi.encodePacked(user.email)) == keccak256(abi.encodePacked(_email)) &&
            user.passwordHash == _passwordHash
        );
    }

    // Get user details by address
    function getUser(address _userAddress) public view returns (string memory, string memory, string memory) {
        User memory user = users[_userAddress];
        require(bytes(user.email).length != 0, "User not found");
        return (user.firstName, user.surname, user.email);
    }
}
