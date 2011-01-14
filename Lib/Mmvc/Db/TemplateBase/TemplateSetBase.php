
    /**
     * Set the [%doc%]
     * @param [%type%] $[%variable%]
     * @throws InvalidsArguments
     */
    public function set[%nameMethod%]($[%variable%]) {
        if (!self::is[%nameMethod%]Valid($[%variable%])) {
            throw new InvalidsArguments((__FILE__), 'The [%variable%] (' . $[%variable%] . ') is invalid');
        }
        $this->[%variable%] = $[%variable%];
    }